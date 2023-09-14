<?php

namespace App\Facades\Masters\Cluster;

use Illuminate\Support\Facades\Facade;

/**
 * @mixin \App\Services\Masters\ClusterService
 *
 * @method static \Illuminate\Support\Collection getAllDataWithRelations()
 * @method static void bulk(array $clusters = [])
 * @method static \Illuminate\Bus\Batch instanceBulk(Illuminate\Bus\Batch $batch)
 *
 * @see \App\Services\Masters\ClusterService
 */
class ClusterService extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'cluster_service';
    }
}
