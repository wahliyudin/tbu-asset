<?php

namespace App\Services\Sidebars;

use App\Enums\Workflows\LastAction;
use App\Models\Transfers\AssetTransfer as TransfersAssetTransfer;
use App\Services\Sidebars\Contracts\SidebarInterface;
use App\Services\Transfers\AssetTransferService;
use Illuminate\Database\Eloquent\Builder;

class AssetTransfer implements SidebarInterface
{
    public function total(): int
    {
        if (!hasPermission('asset_transfer_approv|asset_transfer_reject')) return 0;
        return AssetTransferService::getByCurrentApproval()->count();
    }
}
