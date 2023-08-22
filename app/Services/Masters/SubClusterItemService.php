<?php

namespace App\Services\Masters;

use App\DataTransferObjects\Masters\SubClusterItemData;
use App\Http\Requests\Masters\SubClusterItemStoreRequest;
use App\Models\Masters\SubClusterItem;

class SubClusterItemService
{
    public function all()
    {
        return SubClusterItem::query()->with('subCluster')->get();
    }

    public function updateOrCreate(SubClusterItemStoreRequest $request)
    {
        $data = SubClusterItemData::from($request->all());
        return SubClusterItem::query()->updateOrCreate([
            'id' => $data->key
        ], $data->toArray());
    }

    public function delete(SubClusterItem $subClusterItem)
    {
        return $subClusterItem->delete();
    }
}
