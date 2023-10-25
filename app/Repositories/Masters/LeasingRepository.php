<?php

namespace App\Repositories\Masters;

use App\Models\Masters\Leasing;

class LeasingRepository
{
    public function instance()
    {
        return Leasing::query()->get();
    }

    public function selectByAttributes($others)
    {
        return Leasing::select(array_merge(['id', 'name'], $others))->get();
    }

    public function updateOrCreate($data)
    {
        return Leasing::query()->updateOrCreate([
            'id' => $data['key']
        ], $data);
    }

    public function check($name)
    {
        return Leasing::query()
            ->where('name', trim($name))
            ->first();
    }

    public function destroy(Leasing $leasing)
    {
        return $leasing->delete();
    }

    public function findOrFail($id)
    {
        return Leasing::query()->findOrFail($id);
    }

    public function getAllDataWithRelations()
    {
        return Leasing::query()->get();
    }
}
