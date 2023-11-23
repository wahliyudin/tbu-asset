<?php

namespace App\Services\Masters;

use App\DataTransferObjects\Masters\ClusterData;
use App\Http\Requests\Masters\ClusterStoreRequest;
use App\Facades\Elasticsearch;
use App\Jobs\Masters\Cluster\BulkJob;
use App\Kafka\Enums\Nested;
use App\Kafka\Enums\Topic;
use App\Kafka\Facades\Message;
use App\Models\Masters\Cluster;
use App\Repositories\Masters\ClusterRepository;
use Illuminate\Bus\Batch;
use Illuminate\Support\Facades\DB;

class ClusterService
{
    public function __construct(
        protected ClusterRepository $clusterRepository
    ) {
    }

    public function all()
    {
        return $this->clusterRepository->instance();
    }

    public static function dataForSelect(...$others)
    {
        return (new ClusterRepository)->selectByAttributes($others);
    }

    public function updateOrCreate(ClusterStoreRequest $request)
    {
        return DB::transaction(function () use ($request) {
            $cluster = $this->clusterRepository->updateOrCreate($request->all());
            $this->sendToElasticsearch($cluster, $request->key);
            return $cluster;
        });
    }

    public static function store(array $data)
    {
        if (!isset($data['id']) || !isset($data['name']) || !isset($data['category_id'])) {
            return null;
        }
        if ($cluster = (new ClusterRepository)->check($data['name'], $data['category_id'])) {
            return $cluster;
        }
        return Cluster::query()->create([
            // 'id' => $data['id'],
            'category_id' => $data['category_id'],
            'name' => $data['name'],
        ]);
    }

    public function delete(Cluster $cluster)
    {
        return DB::transaction(function () use ($cluster) {
            Message::deleted(Topic::CLUSTER, 'id', $cluster->getKey(), Nested::CLUSTER);
            return $this->clusterRepository->destroy($cluster);
        });
    }

    public function getDataForEdit($id): array
    {
        return $this->clusterRepository->findOrFail($id)?->toArray();
    }

    private function sendToElasticsearch(Cluster $cluster, $key)
    {
        if ($key) {
            Message::updated(
                Topic::CLUSTER,
                'id',
                $cluster->getKey(),
                Nested::CLUSTER,
                $cluster->toArray()
            );
        }
    }

    public function bulk(array $clusters = [])
    {
        return Elasticsearch::setModel(Cluster::class)
            ->bulk(ClusterData::collection($clusters));
    }

    public function instanceBulk(Batch $batch)
    {
        $clusters = $this->clusterRepository->getAllDataWithRelations()->toArray();
        foreach (array_chunk($clusters, 10) as $clusters) {
            $batch->add(new BulkJob($clusters));
        }
        return $batch;
    }
}
