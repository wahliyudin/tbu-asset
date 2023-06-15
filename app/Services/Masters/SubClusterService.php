<?php

namespace App\Services\Masters;

use App\DataTransferObjects\Masters\SubClusterDTO;
use App\Models\SubCluster;

class SubClusterService
{
    public function all()
    {
        return SubCluster::query()->with('cluster')->get();
    }

    public function updateOrCreate(SubClusterDto $dto)
    {
        return SubCluster::query()->updateOrCreate([
            'id' => $dto->key
        ], [
            'cluster_id' => $dto->cluster_id,
            'name' => $dto->name,
        ]);
    }

    public function delete(SubCluster $category)
    {
        return $category->delete();
    }
}