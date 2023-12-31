<?php

namespace App\Services\Masters;

use App\DataTransferObjects\Masters\SubClusterData;
use App\Http\Requests\Masters\SubClusterStoreRequest;
use App\Facades\Elasticsearch;
use App\Jobs\Masters\SubCluster\BulkJob;
use App\Models\Masters\SubCluster;
use Illuminate\Bus\Batch;
use Illuminate\Support\Facades\DB;

class SubClusterService
{
    public function all($search = null, $length = 50)
    {
        return Elasticsearch::setModel(SubCluster::class)->searchMultiMatch($search, $length)->all();
    }

    public static function dataForSelect(...$others)
    {
        return SubCluster::select(array_merge(['id', 'name'], $others))->get();
    }

    public function updateOrCreate(SubClusterStoreRequest $request)
    {
        $data = SubClusterData::from($request->all());
        return DB::transaction(function () use ($data) {
            $subCluster = SubCluster::query()->updateOrCreate([
                'id' => $data->key
            ], $data->toArray());
            $this->sendToElasticsearch($subCluster, $data->getKey());
            return $subCluster;
        });
    }

    public static function store(array $data)
    {
        if (!isset($data['id']) || !isset($data['name']) || !isset($data['cluster_id'])) {
            return null;
        }
        if ($subCluster = SubCluster::query()->where('id', trim($data['id']))->orWhere('cluster_id', trim($data['cluster_id']))->first()) {
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
            Elasticsearch::setModel(SubCluster::class)->deleted(SubClusterData::from($subCluster));
            return $subCluster->delete();
        });
    }

    public function getDataForEdit($id): array
    {
        $asset = Elasticsearch::setModel(SubCluster::class)->find($id)->asArray();
        return $asset['_source'];
    }

    private function sendToElasticsearch(SubCluster $subCluster, $key)
    {
        $subCluster->load(['cluster.category', 'subClusterItems']);
        if ($key) {
            return Elasticsearch::setModel(SubCluster::class)->updated(SubClusterData::from($subCluster));
        }
        return Elasticsearch::setModel(SubCluster::class)->created(SubClusterData::from($subCluster));
    }

    public function getAllDataWithRelations()
    {
        return SubCluster::query()->with(['cluster.category', 'subClusterItems'])->get();
    }

    public function bulk(array $clusters = [])
    {
        return Elasticsearch::setModel(SubCluster::class)
            ->bulk(SubClusterData::collection($clusters));
    }

    public function instanceBulk(Batch $batch)
    {
        $subClusters = $this->getAllDataWithRelations()->toArray();
        foreach (array_chunk($subClusters, 10) as $subClusters) {
            $batch->add(new BulkJob($subClusters));
        }
        return $batch;
    }
}
