<?php

namespace App\Services\Masters;

use App\DataTransferObjects\Masters\UomDTO;
use App\Models\Masters\Uom;

class UomService
{
    public function all()
    {
        return Uom::query()->get();
    }

    public function updateOrCreate(UomDto $dto)
    {
        return Uom::query()->updateOrCreate([
            'id' => $dto->key
        ], [
            'name' => $dto->name,
            'keterangan' => $dto->keterangan,
        ]);
    }

    public function delete(Uom $uom)
    {
        return $uom->delete();
    }
}
