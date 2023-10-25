<?php

namespace App\Services\Masters;

use App\DataTransferObjects\Masters\SubClusterData;
use App\Http\Requests\Masters\SubClusterStoreRequest;
use App\Facades\Elasticsearch;
use App\Jobs\Masters\SubCluster\BulkJob;
use App\Kafka\Enums\Nested;
use App\Kafka\Enums\Topic;
use App\Kafka\Facades\Message;
use App\Models\Masters\SubCluster;
use App\Repositories\Masters\SubClusterRepository;
use Illuminate\Bus\Batch;
use Illuminate\Support\Facades\DB;

class SubClusterService
{
    public function __construct(
        protected SubClusterRepository $subClusterRepository
    ) {
    }

    public function all()
    {
        return $this->subClusterRepository->instance();
    }

    public static function dataForSelect(...$others)
    {
        return (new SubClusterRepository)->selectByAttributes($others);
    }

    public function updateOrCreate(SubClusterStoreRequest $request)
    {
        return DB::transaction(function () use ($request) {
            $subCluster = $this->subClusterRepository->updateOrCreate($request->all());
            $this->sendToElasticsearch($subCluster, $request->key);
            return $subCluster;
        });
    }

    public static function store(array $data)
    {
        if (!isset($data['id']) || !isset($data['name']) || !isset($data['cluster_id'])) {
            return null;
        }
        if ($subCluster = (new SubClusterRepository)->check($data['name'], $data['cluster_id'])) {
            return $subCluster;
        }
        return SubCluster::query()->create([
            'id' => $data['id'],
            'cluster_id' => $data['cluster_id'],
            'name' => $data['name'],
        ]);
    }

    public function delete(SubCluster $subCluster)
    {
        return DB::transaction(function () use ($subCluster) {
            Message::deleted(Topic::SUB_CLUSTER, 'id', $subCluster->getKey(), Nested::SUB_CLUSTER);
            return $this->subClusterRepository->destroy($subCluster);
        });
    }

    public function getDataForEdit($id): array
    {
        return $this->subClusterRepository->findOrFail($id)?->toArray();
    }

    private function sendToElasticsearch(SubCluster $subCluster, $key)
    {
        if ($key) {
            Message::updated(
                Topic::SUB_CLUSTER,
                'id',
                $subCluster->getKey(),
                Nested::SUB_CLUSTER,
                $subCluster->toArray()
            );
        }
    }

    public function bulk(array $clusters = [])
    {
        return Elasticsearch::setModel(SubCluster::class)
            ->bulk(SubClusterData::collection($clusters));
    }

    public function instanceBulk(Batch $batch)
    {
        $subClusters = $this->subClusterRepository->getAllDataWithRelations()->toArray();
        foreach (array_chunk($subClusters, 10) as $subClusters) {
            $batch->add(new BulkJob($subClusters));
        }
        return $batch;
    }
}
