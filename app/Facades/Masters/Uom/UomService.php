<?php

namespace App\Facades\Masters\Uom;

use Illuminate\Support\Facades\Facade;

/**
 * @mixin \App\Services\Masters\UomService
 *
 * @method static \Illuminate\Support\Collection getAllDataWithRelations()
 * @method static void bulk(array $uoms = [])
 * @method static \Illuminate\Bus\Batch instanceBulk(Illuminate\Bus\Batch $batch)
 *
 * @see \App\Services\Masters\UomService
 */
class UomService extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'uom_service';
    }
}
