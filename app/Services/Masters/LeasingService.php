<?php

namespace App\Services\Masters;

use App\DataTransferObjects\Masters\LeasingData;
use App\Http\Requests\Masters\LeasingStoreRequest;
use App\Models\Masters\Leasing;

class LeasingService
{
    public function all()
    {
        return Leasing::query()->get();
    }

    public function updateOrCreate(LeasingStoreRequest $request)
    {
        $data = LeasingData::from($request->all());
        return Leasing::query()->updateOrCreate([
            'id' => $data->key
        ], $data->toArray());
    }

    public function delete(Leasing $category)
    {
        return $category->delete();
    }
}
