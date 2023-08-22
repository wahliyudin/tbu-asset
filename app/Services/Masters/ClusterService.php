<?php

namespace App\Services\Masters;

use App\DataTransferObjects\Masters\ClusterData;
use App\Http\Requests\Masters\ClusterStoreRequest;
use App\Models\Masters\Cluster;

class ClusterService
{
    public function all()
    {
        return Cluster::query()->with('category')->get();
    }

    public function updateOrCreate(ClusterStoreRequest $request)
    {
        $data = ClusterData::from($request->all());
        return Cluster::query()->updateOrCreate([
            'id' => $data->key
        ], $data->toArray());
    }

    public function delete(Cluster $cluster)
    {
        return $cluster->delete();
    }
}
