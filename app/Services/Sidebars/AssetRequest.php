<?php

namespace App\Services\Sidebars;

use App\Enums\Workflows\LastAction;
use App\Models\Cers\Cer;
use App\Services\Cers\CerService;
use App\Services\Sidebars\Contracts\SidebarInterface;
use Illuminate\Database\Eloquent\Builder;

class AssetRequest implements SidebarInterface
{
    public function total(): int
    {
        if (!hasPermission('asset_request_approv|asset_request_reject')) return 0;
        return CerService::getByCurrentApproval()->count();
    }
}
