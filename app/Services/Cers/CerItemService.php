<?php

namespace App\Services\Cers;

use App\Enums\Workflows\Status;
use App\Models\Cers\CerItem;
use App\Services\API\TXIS\CerService;

class CerItemService
{
    public function getAllByReadyToRegister()
    {
        return CerItem::query()->get();
    }

    public function all(...$columns)
    {
        return CerItem::select(array_merge(['id'], $columns))
            ->whereHas('cer', function ($query) {
                $query->where('status', Status::CLOSE);
            })->get();
    }

    public function getCerItemTxis($code)
    {
        $data = (new CerService)->getByCode($code);
        return isset($data['data']) ? $data['data'] : [];
    }
}
