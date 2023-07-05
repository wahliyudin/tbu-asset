<?php

namespace App\Services\Masters;

use App\DataTransferObjects\Masters\UomData;
use App\Models\Masters\Uom;

class UomService
{
    public function all()
    {
        return Uom::query()->get();
    }

    public function updateOrCreate(UomData $data)
    {
        return Uom::query()->updateOrCreate([
            'id' => $data->key
        ], [
            'name' => $data->name,
            'keterangan' => $data->keterangan,
        ]);
    }

    public function delete(Uom $uom)
    {
        return $uom->delete();
    }
}