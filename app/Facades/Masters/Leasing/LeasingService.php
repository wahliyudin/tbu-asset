<?php

namespace App\Facades\Masters\Leasing;

use Illuminate\Support\Facades\Facade;

/**
 * @mixin \App\Services\Masters\LeasingService
 *
 * @method static \Illuminate\Support\Collection getAllDataWithRelations()
 * @method static void bulk(array $leasings = [])
 * @method static \Illuminate\Bus\Batch instanceBulk(Illuminate\Bus\Batch $batch)
 *
 * @see \App\Services\Masters\LeasingService
 */
class LeasingService extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'leasing_service';
    }
}
