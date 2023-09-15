<?php

namespace App\Services\Cers;

use App\Enums\Workflows\Status;
use App\Models\Cers\CerItem;
use App\Services\API\TXIS\CerService;

class CerItemService
{
    public function __construct(
        protected CerService $cerService
    ) {
    }

    public function getAllByReadyToRegister()
    {
        return CerItem::query()->whereHas('cer', function ($query) {
            $query->whereTrue('status_pr');
        })->with('cer')->get();
    }

    public function all(...$columns)
    {
        return CerItem::select(array_merge(['id'], $columns))
            ->whereHas('cer', function ($query) {
                $query->where('status', Status::CLOSE);
            })->get();
    }

    public function getByCerItemId($code)
    {
        $data = $this->cerService->getByCerItemId($code);
        return isset($data['data']) ? $data['data'] : [];
    }
}
