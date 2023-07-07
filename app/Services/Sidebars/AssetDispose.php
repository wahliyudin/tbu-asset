<?php

namespace App\Services\Sidebars;

use App\Services\Disposes\AssetDisposeService;
use App\Services\Sidebars\Contracts\SidebarInterface;

class AssetDispose implements SidebarInterface
{
    public function total(): int
    {
        if (!hasPermission('asset_dispose_approv|asset_dispose_reject')) return 0;
        return AssetDisposeService::getByCurrentApproval()->count();
    }
}
