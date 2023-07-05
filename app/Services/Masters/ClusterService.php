<?php

namespace App\Services\Masters;

use App\DataTransferObjects\Masters\ClusterData;
use App\Models\Masters\Cluster;

class ClusterService
{
    public function all()
    {
        return Cluster::query()->with('category')->get();
    }

    public function updateOrCreate(ClusterData $data)
    {
        return Cluster::query()->updateOrCreate([
            'id' => $data->key
        ], [
            'category_id' => $data->category_id,
            'name' => $data->name,
        ]);
    }

    public function delete(Cluster $cluster)
    {
        return $cluster->delete();
    }
}