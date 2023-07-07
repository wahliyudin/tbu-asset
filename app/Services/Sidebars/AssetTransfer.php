<?php

namespace App\Services\Sidebars;

use App\Enums\Workflows\LastAction;
use App\Models\Transfers\AssetTransfer as TransfersAssetTransfer;
use App\Services\Sidebars\Contracts\SidebarInterface;
use Illuminate\Database\Eloquent\Builder;

class AssetTransfer implements SidebarInterface
{
    public function total(): int
    {
        if (!hasPermission('asset_transfer_approv|asset_transfer_reject')) return 0;
        return TransfersAssetTransfer::query()->whereHas('workflows', function (Builder $query) {
            $query->where('last_action', LastAction::NOTTING)
                ->where('nik', auth()->user()?->nik);
        })->count();
    }
}
