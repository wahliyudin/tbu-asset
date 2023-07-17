<?php

namespace App\Services\Masters;

use App\DataTransferObjects\Masters\SubClusterData;
use App\Facades\Elasticsearch;
use App\Models\Masters\SubCluster;

class SubClusterService
{
    public function all($search = null)
    {
        return Elasticsearch::setModel(SubCluster::class)->searchQueryString($search, 50)->all();
    }

    public function updateOrCreate(SubClusterData $data)
    {
        $subCluster = SubCluster::query()->updateOrCreate([
            'id' => $data->getKey()
        ], [
            'cluster_id' => $data->cluster_id,
            'name' => $data->name,
        ]);
        $this->sendToElasticsearch($subCluster, $data->getKey());
        return $subCluster;
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
