<?php

namespace App\Services\Masters;

use App\DataTransferObjects\Masters\DealerDTO;
use App\Models\Masters\Dealer;

class DealerService
{
    public function all()
    {
        return Dealer::query()->get();
    }

    public function updateOrCreate(DealerDto $dto)
    {
        return Dealer::query()->updateOrCreate([
            'id' => $dto->key
        ], [
            'name' => $dto->name,
        ]);
    }

    public function delete(Dealer $category)
    {
        return $category->delete();
    }
}
