<?php

namespace App\Services\Masters;

use App\DataTransferObjects\Masters\LeasingData;
use App\Models\Masters\Leasing;

class LeasingService
{
    public function all()
    {
        return Leasing::query()->get();
    }

    public function updateOrCreate(LeasingData $data)
    {
        return Leasing::query()->updateOrCreate([
            'id' => $data->key
        ], [
            'name' => $data->name,
        ]);
    }

    public function delete(Leasing $category)
    {
        return $category->delete();
    }
}