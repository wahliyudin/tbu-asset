<?php

namespace App\Repositories\Masters;

use App\Models\Masters\Category;

class CategoryRepository
{
    public function instance()
    {
        return Category::query();
    }

    public function selectByAttributes(...$others)
    {
        return Category::select(array_merge(['id', 'name'], $others))->get();
    }

    public function updateOrCreate($data)
    {
        return Category::query()->updateOrCreate([
            'id' => $data['key']
        ], $data);
    }

    public function check($name)
    {
        return Category::query()->where('name', trim($name))->first();
    }

    public function destroy(Category $category)
    {
        return $category->delete();
    }

    public function findOrFail($id)
    {
        return Category::query()->findOrFail($id);
    }

    public function getAllDataWithRelations()
    {
        return Category::query()->with(['clusters.subClusters.subClusterItems'])->get();
    }
}
