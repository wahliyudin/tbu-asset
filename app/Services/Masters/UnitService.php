<?php

namespace App\Services\Masters;

use App\DataTransferObjects\Masters\UnitData;
use App\Http\Requests\Masters\UnitStoreRequest;
use App\Facades\Elasticsearch;
use App\Jobs\Masters\Unit\BulkJob;
use App\Kafka\Enums\Nested;
use App\Kafka\Enums\Topic;
use App\Kafka\Facades\Message;
use App\Models\Masters\Unit;
use App\Repositories\Masters\UnitRepository;
use Illuminate\Bus\Batch;
use Illuminate\Support\Facades\DB;

class UnitService
{
    public function __construct(
        protected UnitRepository $unitRepository
    ) {
    }

    public function all()
    {
        return $this->unitRepository->instance();
    }

    public static function dataForSelect(...$others)
    {
        return (new UnitRepository)->selectByAttributes($others);
    }

    public function updateOrCreate(UnitStoreRequest $request)
    {
        return DB::transaction(function () use ($request) {
            $unit = $this->unitRepository->updateOrCreate($request->all());
            $this->sendToElasticsearch($unit, $request->key);
            return $unit;
        });
    }

    public static function store(array $data)
    {
        if (!isset($data['prefix']) || !isset($data['model'])) {
            return null;
        }
        if ($unit = (new UnitRepository)->check($data['prefix'], $data['model'])) {
            return $unit;
        }
        return Unit::query()->create([
            'prefix' => isset($data['prefix']) ? $data['prefix'] : null,
            'model' => isset($data['model']) ? $data['model'] : null,
        ]);
    }

    public function delete(Unit $unit)
    {
        return DB::transaction(function () use ($unit) {
            Message::deleted(Topic::UNIT, 'id', $unit->getKey(), Nested::UNIT);
            return $this->unitRepository->destroy($unit);
        });
    }

    public function getDataForEdit($id): array
    {
        return $this->unitRepository->findOrFail($id)?->toArray();
    }

    private function sendToElasticsearch(Unit $unit, $key)
    {
        if ($key) {
            Message::updated(
                Topic::UNIT,
                'id',
                $unit->getKey(),
                Nested::UNIT,
                $unit->toArray()
            );
        }
    }

    public function bulk(array $clusters = [])
    {
        return Elasticsearch::setModel(Unit::class)
            ->bulk(UnitData::collection($clusters));
    }

    public function instanceBulk(Batch $batch)
    {
        $units = $this->unitRepository->getAllDataWithRelations()->toArray();
        foreach (array_chunk($units, 10) as $units) {
            $batch->add(new BulkJob($units));
        }
        return $batch;
    }
}
