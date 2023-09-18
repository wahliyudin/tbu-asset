<?php

namespace App\Services\Cers;

use App\Enums\Workflows\Status;
use App\Models\Cers\CerItem;
use App\Services\API\TXIS\CerService;
use App\Services\Assets\AssetService;
use Illuminate\Http\Request;

class CerItemService
{
    public function __construct(
        protected CerService $cerService,
        protected AssetService $assetService,
    ) {
    }

    public function getAllByReadyToRegister()
    {
        return CerItem::query()->with('cer')->where('is_register', false)->get();
    }

    public function all(...$columns)
    {
        return CerItem::select(array_merge(['id'], $columns))
            ->whereHas('cer', function ($query) {
                $query->where('status', Status::CLOSE);
            })->get();
    }

    public function getByCerItemId($id)
    {
        $data = $this->cerService->getByCerItemId($id);
        return isset($data['data']) ? $data['data'] : [];
    }

    public function register(CerItem $cerItem, Request $request)
    {
        $this->assetService->updateOrCreate($request);
        $cerItem->update([
            'is_register' => true
        ]);
    }
}
