<?php

namespace App\Services\Masters;

use App\DataTransferObjects\Masters\SubClusterData;
use App\Http\Requests\Masters\SubClusterStoreRequest;
use App\Models\Masters\SubCluster;

class SubClusterService
{
    public function all()
    {
        return SubCluster::query()->with('cluster')->get();
    }

    public function updateOrCreate(SubClusterStoreRequest $request)
    {
        $data = SubClusterData::from($request->all());
        return SubCluster::query()->updateOrCreate([
            'id' => $data->key
        ], $data->toArray());
    }

    public function delete(SubCluster $subCluster)
    {
        return $subCluster->delete();
    }
}
