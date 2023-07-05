<?php

namespace App\Services\Masters;

use App\DataTransferObjects\Masters\UnitData;
use App\Models\Masters\Unit;

class UnitService
{
    public function all()
    {
        return Unit::query()->get();
    }

    public function updateOrCreate(UnitData $data)
    {
        return Unit::query()->updateOrCreate([
            'id' => $data->key
        ], [
            'kode' => $data->kode,
            'model' => $data->model,
            'type' => $data->type,
            'seri' => $data->seri,
            'class' => $data->class,
            'brand' => $data->brand,
            'serial_number' => $data->serial_number,
            'spesification' => $data->spesification,
            'tahun_pembuatan' => $data->tahun_pembuatan,
        ]);
    }

    public function delete(Unit $category)
    {
        return $category->delete();
    }
}