<?php

namespace App\Services\Masters;

use App\DataTransferObjects\Masters\UnitDTO;
use App\Models\Masters\Unit;

class UnitService
{
    public function all()
    {
        return Unit::query()->get();
    }

    public function updateOrCreate(UnitDto $dto)
    {
        return Unit::query()->updateOrCreate([
            'id' => $dto->key
        ], [
            'kode' => $dto->kode,
            'model' => $dto->model,
            'type' => $dto->type,
            'seri' => $dto->seri,
            'class' => $dto->class,
            'brand' => $dto->brand,
            'serial_number' => $dto->serial_number,
            'spesification' => $dto->spesification,
            'tahun_pembuatan' => $dto->tahun_pembuatan,
        ]);
    }

    public function delete(Unit $category)
    {
        return $category->delete();
    }
}
