<?php

namespace App\Services\Masters;

use App\DataTransferObjects\Masters\LeasingDTO;
use App\Models\Leasing;

class LeasingService
{
    public function all()
    {
        return Leasing::query()->get();
    }

    public function updateOrCreate(LeasingDto $dto)
    {
        return Leasing::query()->updateOrCreate([
            'id' => $dto->key
        ], [
            'name' => $dto->name,
        ]);
    }

    public function delete(Leasing $category)
    {
        return $category->delete();
    }
}