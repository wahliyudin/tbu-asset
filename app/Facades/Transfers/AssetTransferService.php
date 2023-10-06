<?php

namespace App\Facades\Transfers;

use App\Enums\Transfers\Transfer\Status;
use App\Models\Transfers\AssetTransfer;
use Illuminate\Support\Facades\Facade;

/**
 * @mixin \App\Services\Transfers\AssetTransferService
 *
 * @method static AssetTransfer statusTransfer(AssetTransfer $assetTransfer, Status $status)
 *
 * @see \App\Services\Transfers\AssetTransferService
 */
class AssetTransferService extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'asset_transfer_service';
    }
}
