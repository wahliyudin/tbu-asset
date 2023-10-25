<?php

namespace App\Repositories\Masters;

use App\Models\Masters\Cluster;

class ClusterRepository
{
    public function instance()
    {
        return Cluster::query()->with('category')->get();
    }

    public function selectByAttributes($others)
    {
        return Cluster::select(array_merge(['id', 'name'], $others))->get();
    }

    public function updateOrCreate($data)
    {
        return Cluster::query()->updateOrCreate([
            'id' => $data['key']
        ], $data);
    }

    public function check($name, $category_id)
    {
        return Cluster::query()
            ->where('name', trim($name))
            ->where('category_id', trim($category_id))
            ->first();
    }

    public function destroy(Cluster $category)
    {
        return $category->delete();
    }

    public function findOrFail($id)
    {
        return Cluster::query()->with('category')->findOrFail($id);
    }

    public function getAllDataWithRelations()
    {
        return Cluster::query()->with(['category'])->get();
    }
}
