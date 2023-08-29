<?php

namespace App\Services\Masters;

use App\DataTransferObjects\Masters\SubClusterData;
use App\Http\Requests\Masters\SubClusterStoreRequest;
use App\Facades\Elasticsearch;
use App\Models\Masters\SubCluster;

class SubClusterService
{
    public function all($search = null)
    {
        return Elasticsearch::setModel(SubCluster::class)->searchQueryString($search, 50)->all();
    }

    public static function dataForSelect(...$others)
    {
        return SubCluster::select(array_merge(['id', 'name'], $others))->get();
    }

    public function updateOrCreate(SubClusterStoreRequest $request)
    {
        $data = SubClusterData::from($request->all());
        $subCluster = SubCluster::query()->updateOrCreate([
            'id' => $data->key
        ], $data->toArray());
        $this->sendToElasticsearch($subCluster, $data->getKey());
        return $subCluster;
    }

    public static function store(SubClusterData $data)
    {
        if ($subCluster = SubCluster::query()->where('name', 'like', $data->name)->first()) {
            return $subCluster;
        }
        return SubCluster::query()->create([
            'cluster_id' => $data->cluster_id,
            'name' => $data->name,
        ]);
    }

    public function delete(SubCluster $subCluster)
    {
        Elasticsearch::setModel(SubCluster::class)->deleted(SubClusterData::from($subCluster));
        return $subCluster->delete();
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
}
