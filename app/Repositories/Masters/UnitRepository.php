<?php

namespace App\Repositories\Masters;

use App\Models\Masters\Unit;

class UnitRepository
{
    public function instance()
    {
        return Unit::query()->get();
    }

    public function selectByAttributes($others)
    {
        return Unit::select(array_merge(['id', 'prefix', 'model'], $others))->get();
    }

    public function updateOrCreate($data)
    {
        return Unit::query()->updateOrCreate([
            'id' => $data['key']
        ], $data);
    }

    public function check($prefix, $model)
    {
        return Unit::query()
            ->where('prefix', trim($prefix))
            ->orWhere('model', trim($model))
            ->first();
    }

    public function destroy(Unit $category)
    {
        return $category->delete();
    }

    public function findOrFail($id)
    {
        return Unit::query()->findOrFail($id);
    }

    public function getAllDataWithRelations()
    {
        return Unit::query()->with(['clusters.subClusters.subClusterItems'])->get();
    }
}
