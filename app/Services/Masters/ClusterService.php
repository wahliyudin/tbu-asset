<?php

namespace App\Services\Masters;

use App\DataTransferObjects\Masters\ClusterData;
use App\Facades\Elasticsearch;
use App\Models\Masters\Cluster;

class ClusterService
{
    public function all($search = null)
    {
        return Elasticsearch::setModel(Cluster::class)->searchQueryString($search, 50)->all();
    }

    public function updateOrCreate(ClusterData $data)
    {
        $cluster = Cluster::query()->updateOrCreate([
            'id' => $data->getKey()
        ], [
            'category_id' => $data->category_id,
            'name' => $data->name,
        ]);
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