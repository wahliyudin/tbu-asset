<?php

namespace App\Services\Masters;

use App\DataTransferObjects\Masters\SubClusterData;
use App\Models\Masters\SubCluster;

class SubClusterService
{
    public function all()
    {
        return SubCluster::query()->with('cluster')->get();
    }

    public function updateOrCreate(SubClusterData $data)
    {
        return SubCluster::query()->updateOrCreate([
            'id' => $data->key
        ], [
            'cluster_id' => $data->cluster_id,
            'name' => $data->name,
        ]);
    }

    public function delete(SubCluster $subCluster)
    {
        return $subCluster->delete();
    }
}