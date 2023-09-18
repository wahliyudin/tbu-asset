<?php

namespace App\Facades\Assets;

use Illuminate\Support\Facades\Facade;

/**
 * @mixin \App\Services\Assets\AssetService
 *
 * @method static \App\Services\Assets\AssetService import(array $data)
 * @method static string nextKode(string $kode)
 *
 * @see \App\Services\Assets\AssetService
 */
class AssetService extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'asset_service';
    }
}
