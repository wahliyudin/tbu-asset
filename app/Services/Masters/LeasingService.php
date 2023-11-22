<?php

namespace App\Services\Masters;

use App\DataTransferObjects\Masters\LeasingData;
use App\Http\Requests\Masters\LeasingStoreRequest;
use App\Facades\Elasticsearch;
use App\Jobs\Masters\Leasing\BulkJob;
use App\Kafka\Enums\Nested;
use App\Kafka\Enums\Topic;
use App\Kafka\Facades\Message;
use App\Models\Masters\Leasing;
use App\Repositories\Masters\LeasingRepository;
use Illuminate\Bus\Batch;
use Illuminate\Support\Facades\DB;

class LeasingService
{
    public function __construct(
        protected LeasingRepository $leasingRepository
    ) {
    }

    public function all()
    {
        return $this->leasingRepository->instance();
    }

    public static function dataForSelect(...$others)
    {
        return (new LeasingRepository)->selectByAttributes($others);
    }

    public function updateOrCreate(LeasingStoreRequest $request)
    {
        return DB::transaction(function () use ($request) {
            $leasing = $this->leasingRepository->updateOrCreate($request->all());
            $this->sendToElasticsearch($leasing, $request->key);
            return $leasing;
        });
    }

    public function store(LeasingData $data)
    {
        if (!isset($data->name)) {
            return null;
        }
        $leasing = $this->leasingRepository->check($data->name);
        if ($leasing) {
            return $leasing;
        }

        return Leasing::query()->create([
            'name' => $data->name,
        ]);
    }

    public function delete(Leasing $leasing)
    {
        return DB::transaction(function () use ($leasing) {
            Elasticsearch::setModel(Leasing::class)->deleted(LeasingData::from($leasing));
            return $leasing->delete();
        });
    }

    public function getDataForEdit($id): array
    {
        return $this->leasingRepository->findOrFail($id)?->toArray();
    }

    private function sendToElasticsearch(Leasing $leasing, $key)
    {
        if ($key) {
            Message::updated(
                Topic::LEASING,
                'id',
                $leasing->getKey(),
                Nested::LEASING,
                $leasing->toArray()
            );
        }
    }

    public function bulk(array $clusters = [])
    {
        return Elasticsearch::setModel(Leasing::class)
            ->bulk(LeasingData::collection($clusters));
    }

    public function instanceBulk(Batch $batch)
    {
        $leasings = $this->leasingRepository->getAllDataWithRelations()->toArray();
        foreach (array_chunk($leasings, 10) as $leasings) {
            $batch->add(new BulkJob($leasings));
        }
        return $batch;
    }
}
