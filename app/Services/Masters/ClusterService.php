<?php

namespace App\Services\Masters;

use App\DataTransferObjects\Masters\ClusterDTO;
use App\Models\Cluster;

class ClusterService
{
    public function all()
    {
        return Cluster::query()->with('category')->get();
    }

    public function updateOrCreate(ClusterDto $dto)
    {
        return Cluster::query()->updateOrCreate([
            'id' => $dto->key
        ], [
            'category_id' => $dto->category_id,
            'name' => $dto->name,
        ]);
    }

    public function delete(Cluster $category)
    {
        return $category->delete();
    }
}