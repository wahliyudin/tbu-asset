<?php

namespace App\Services\Cers;

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
        return CerItem::select(array_merge(['id'], $columns))->get();
    }

    public function getCerItemTxis($code)
    {
        $data = (new CerService)->getByCode($code);
        return isset($data['data']) ? $data['data'] : [];
    }
}
