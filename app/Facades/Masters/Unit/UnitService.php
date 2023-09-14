<?php

namespace App\Facades\Masters\Unit;

use Illuminate\Support\Facades\Facade;

/**
 * @mixin \App\Services\Masters\UnitService
 *
 * @method static \Illuminate\Support\Collection getAllDataWithRelations()
 * @method static void bulk(array $units = [])
 * @method static \Illuminate\Bus\Batch instanceBulk(Illuminate\Bus\Batch $batch)
 *
 * @see \App\Services\Masters\UnitService
 */
class UnitService extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'unit_service';
    }
}
