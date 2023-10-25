<?php

namespace App\Repositories\Masters;

use App\Models\Masters\Activity;

class ActivityRepository
{
    public function instance()
    {
        return Activity::query()->get();
    }

    public function selectByAttributes($others)
    {
        return Activity::select(array_merge(['id', 'name'], $others))->get();
    }

    public function updateOrCreate($data)
    {
        return Activity::query()->updateOrCreate([
            'id' => $data['key']
        ], $data);
    }

    public function check($name)
    {
        return Activity::query()
            ->orWhere('model', trim($name))
            ->first();
    }

    public function destroy(Activity $activity)
    {
        return $activity->delete();
    }

    public function findOrFail($id)
    {
        return Activity::query()->findOrFail($id);
    }

    public function getAllDataWithRelations()
    {
        return Activity::query()->get();
    }
}
