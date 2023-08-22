<?php

namespace App\Services\Masters;

use App\DataTransferObjects\Masters\DealerData;
use App\Http\Requests\Masters\DealerStoreRequest;
use App\Models\Masters\Dealer;

class DealerService
{
    public function all()
    {
        return Dealer::query()->get();
    }

    public function updateOrCreate(DealerStoreRequest $request)
    {
        $data = DealerData::from($request->all());
        return Dealer::query()->updateOrCreate([
            'id' => $data->key
        ], $data->toArray());
    }

    public function delete(Dealer $category)
    {
        return $category->delete();
    }
}
