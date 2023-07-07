<?php

namespace App\Services\Sidebars;

use App\Enums\Workflows\LastAction;
use App\Models\Disposes\AssetDispose as DisposesAssetDispose;
use App\Services\Sidebars\Contracts\SidebarInterface;
use Illuminate\Database\Eloquent\Builder;

class AssetDispose implements SidebarInterface
{
    public function total(): int
    {
        if (!hasPermission('asset_dispose_approv|asset_dispose_reject')) return 0;
        return DisposesAssetDispose::query()->whereHas('workflows', function (Builder $query) {
            $query->where('last_action', LastAction::NOTTING)
                ->where('nik', auth()->user()?->nik);
        })->count();
    }
}