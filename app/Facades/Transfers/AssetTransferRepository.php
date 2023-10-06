<?php

namespace App\Facades\Transfers;

use App\Elasticsearch\Elasticsearch;
use App\Models\Transfers\AssetTransfer;
use Illuminate\Support\Facades\Facade;

/**
 * @mixin \App\Repositories\Transfers\AssetTransferRepository
 *
 * @method static Elasticsearch sendToElasticsearch(AssetTransfer $assetTransfer, $key)
 *
 * @see \App\Repositories\Transfers\AssetTransferRepository
 */
class AssetTransferRepository extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'asset_transfer_repository';
    }
}
