<?php

namespace App\Repositories\Masters;

use App\Models\Masters\Uom;

class UomRepository
{
    public function instance()
    {
        return Uom::query()->get();
    }

    public function selectByAttributes($others)
    {
        return Uom::select(array_merge(['id', 'name', 'keterangan'], $others))->get();
    }

    public function updateOrCreate($data)
    {
        return Uom::query()->updateOrCreate([
            'id' => $data['id']
        ], $data);
    }

    public function check($name)
    {
        return Uom::query()
            ->where('name', trim($name))
            ->first();
    }

    public function destroy(Uom $uom)
    {
        return $uom->delete();
    }

    public function findOrFail($id)
    {
        return Uom::query()->findOrFail($id);
    }

    public function getAllDataWithRelations()
    {
        return Uom::query()->get();
    }
}
