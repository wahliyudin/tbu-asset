<?php

namespace App\Services\Masters;

use App\DataTransferObjects\Masters\UomData;
use App\Http\Requests\Masters\UomStoreRequest;
use App\Models\Masters\Uom;

class UomService
{
    public function all()
    {
        return Uom::query()->get();
    }

    public function updateOrCreate(UomStoreRequest $request)
    {
        $data = UomData::from($request->all());
        return Uom::query()->updateOrCreate([
            'id' => $data->id
        ], $data->toArray());
    }

    public function delete(Uom $uom)
    {
        return $uom->delete();
    }
}
