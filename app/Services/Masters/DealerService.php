<?php

namespace App\Services\Masters;

use App\DataTransferObjects\Masters\DealerData;
use App\Models\Masters\Dealer;

class DealerService
{
    public function all()
    {
        return Dealer::query()->get();
    }

    public function updateOrCreate(DealerData $data)
    {
        return Dealer::query()->updateOrCreate([
            'id' => $data->key
        ], [
            'name' => $data->name,
        ]);
    }

    public function delete(Dealer $category)
    {
        return $category->delete();
    }
}