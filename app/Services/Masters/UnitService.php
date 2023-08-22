<?php

namespace App\Services\Masters;

use App\DataTransferObjects\Masters\UnitData;
use App\Http\Requests\Masters\UnitStoreRequest;
use App\Models\Masters\Unit;

class UnitService
{
    public function all()
    {
        return Unit::query()->get();
    }

    public static function dataForSelect(...$others)
    {
        return Unit::select(array_merge(['id', 'model'], $others))->get();
    }

    public function updateOrCreate(UnitStoreRequest $request)
    {
        $data = UnitData::from($request->all());
        return Unit::query()->updateOrCreate([
            'id' => $data->key
        ], $data->toArray());
    }

    public function delete(Unit $category)
    {
        return $category->delete();
    }
}
