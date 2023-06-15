<?php

namespace App\Services\Masters;

use App\DataTransferObjects\Masters\SubClusterItemDTO;
use App\Models\SubClusterItem;

class SubClusterItemService
{
    public function all()
    {
        return SubClusterItem::query()->with('subCluster')->get();
    }

    public function updateOrCreate(SubClusterItemDto $dto)
    {
        return SubClusterItem::query()->updateOrCreate([
            'id' => $dto->key
        ], [
            'sub_cluster_id' => $dto->sub_cluster_id,
            'name' => $dto->name,
        ]);
    }

    public function delete(SubClusterItem $subClusterItem)
    {
        return $subClusterItem->delete();
    }
}