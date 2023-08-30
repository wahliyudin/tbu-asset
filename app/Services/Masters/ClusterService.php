<?php

namespace App\Services\Masters;

use App\DataTransferObjects\Masters\ClusterData;
use App\Http\Requests\Masters\ClusterStoreRequest;
use App\Facades\Elasticsearch;
use App\Models\Masters\Cluster;

class ClusterService
{
    public function all($search = null, $length = 50)
    {
        return Elasticsearch::setModel(Cluster::class)->searchMultiMatch($search, $length)->all();
    }

    public static function dataForSelect(...$others)
    {
        return Cluster::select(array_merge(['id', 'name'], $others))->get();
    }

    public function updateOrCreate(ClusterStoreRequest $request)
    {
        $data = ClusterData::from($request->all());
        $cluster = Cluster::query()->updateOrCreate([
            'id' => $data->key
        ], $data->toArray());
        $this->sendToElasticsearch($cluster, $data->getKey());
        return $cluster;
    }

    public static function store(ClusterData $data)
    {
        if ($cluster = Cluster::query()->where('name', 'like', $data->name)->first()) {
            return $cluster;
        }
        return Cluster::query()->create([
            'category_id' => $data->category_id,
            'name' => $data->name,
        ]);
    }

    public function delete(Cluster $cluster)
    {
        Elasticsearch::setModel(Cluster::class)->deleted(ClusterData::from($cluster));
        return $cluster->delete();
    }

    public function getDataForEdit($id): array
    {
        $asset = Elasticsearch::setModel(Cluster::class)->find($id)->asArray();
        return $asset['_source'];
    }

    private function sendToElasticsearch(Cluster $cluster, $key)
    {
        $cluster->load(['subClusters.subClusterItems', 'category']);
        if ($key) {
            return Elasticsearch::setModel(Cluster::class)->updated(ClusterData::from($cluster));
        }
        return Elasticsearch::setModel(Cluster::class)->created(ClusterData::from($cluster));
    }
}
