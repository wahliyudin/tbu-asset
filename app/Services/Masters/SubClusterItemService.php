<?php

namespace App\Services\Masters;

use App\DataTransferObjects\Masters\SubClusterItemData;
use App\Models\Masters\SubClusterItem;

class SubClusterItemService
{
    public function all()
    {
        return SubClusterItem::query()->with('subCluster')->get();
    }

    public function updateOrCreate(SubClusterItemData $data)
    {
        return SubClusterItem::query()->updateOrCreate([
            'id' => $data->key
        ], [
            'sub_cluster_id' => $data->sub_cluster_id,
            'name' => $data->name,
        ]);
    }

    public function delete(SubClusterItem $subClusterItem)
    {
        return $subClusterItem->delete();
    }
}