<?php

namespace App\Services\Masters;

use App\DataTransferObjects\Masters\UomData;
use App\Facades\Elasticsearch;
use App\Http\Requests\Masters\UomStoreRequest;
use App\Jobs\Masters\Uom\BulkJob;
use App\Kafka\Enums\Nested;
use App\Kafka\Enums\Topic;
use App\Kafka\Facades\Message;
use App\Models\Masters\Uom;
use App\Repositories\Masters\UomRepository;
use Illuminate\Bus\Batch;
use Illuminate\Support\Facades\DB;

class UomService
{
    public function __construct(
        protected UomRepository $uomRepository
    ) {
    }

    public function all()
    {
        return $this->uomRepository->instance();
    }

    public static function dataForSelect(...$others)
    {
        return (new UomRepository)->selectByAttributes($others);
    }

    public function updateOrCreate(UomStoreRequest $request)
    {
        return DB::transaction(function () use ($request) {
            $uom = $this->uomRepository->updateOrCreate($request->all());
            $this->sendToElasticsearch($uom, $request->id);
            return $uom;
        });
    }

    public function store(array $data)
    {
        if (!isset($data['name'])) {
            return null;
        }

        $uom = $this->uomRepository->check($data['name']);
        if ($uom) {
            return $uom;
        }

        return Uom::query()->create([
            'name' => $data['name'],
            'keterangan' => isset($data['keterangan']) ? $data['keterangan'] : null
        ]);
    }

    public function delete(Uom $uom)
    {
        return DB::transaction(function () use ($uom) {
            Message::deleted(Topic::UOM, 'id', $uom->getKey(), Nested::UOM);
            return $this->uomRepository->destroy($uom);
        });
    }

    public function getDataForEdit($id): array
    {
        return $this->uomRepository->findOrFail($id)?->toArray();
    }

    private function sendToElasticsearch(Uom $uom, $key)
    {
        if ($key) {
            Message::updated(
                Topic::UOM,
                'id',
                $uom->getKey(),
                Nested::UOM,
                $uom->toArray()
            );
        }
    }

    public function bulk(array $clusters = [])
    {
        return Elasticsearch::setModel(Uom::class)
            ->bulk(UomData::collection($clusters));
    }

    public function instanceBulk(Batch $batch)
    {
        $units = $this->uomRepository->getAllDataWithRelations()->toArray();
        foreach (array_chunk($units, 10) as $units) {
            $batch->add(new BulkJob($units));
        }
        return $batch;
    }
}
