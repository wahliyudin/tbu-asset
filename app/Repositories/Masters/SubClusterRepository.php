<?php

namespace App\Repositories\Masters;

use App\Models\Masters\SubCluster;

class SubClusterRepository
{
    public function instance()
    {
        return SubCluster::query()->with('cluster')->get();
    }

    public function selectByAttributes($others)
    {
        return SubCluster::select(array_merge(['id', 'name'], $others))->get();
    }

    public function updateOrCreate($data)
    {
        return SubCluster::query()->updateOrCreate([
            'id' => $data['key']
        ], $data);
    }

    public function check($name, $cluster_id)
    {
        return SubCluster::query()
            ->where('name', trim($name))
            ->where('cluster_id', trim($cluster_id))
            ->first();
    }

    public function destroy(SubCluster $subCluster)
    {
        return $subCluster->delete();
    }

    public function findOrFail($id)
    {
        return SubCluster::query()->with('cluster')->findOrFail($id);
    }

    public function getAllDataWithRelations()
    {
        return SubCluster::query()->with(['cluster'])->get();
    }
}
