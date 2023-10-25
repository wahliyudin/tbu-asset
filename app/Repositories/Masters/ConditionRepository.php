<?php

namespace App\Repositories\Masters;

use App\Models\Masters\Condition;

class ConditionRepository
{
    public function instance()
    {
        return Condition::query()->get();
    }

    public function selectByAttributes($others)
    {
        return Condition::select(array_merge(['id', 'name'], $others))->get();
    }

    public function updateOrCreate($data)
    {
        return Condition::query()->updateOrCreate([
            'id' => $data['key']
        ], $data);
    }

    public function check($name)
    {
        return Condition::query()
            ->orWhere('name', trim($name))
            ->first();
    }

    public function destroy(Condition $condition)
    {
        return $condition->delete();
    }

    public function findOrFail($id)
    {
        return Condition::query()->findOrFail($id);
    }

    public function getAllDataWithRelations()
    {
        return Condition::query()->get();
    }
}
