<?php

namespace App\Facades\Masters\SubCluster;

use Illuminate\Support\Facades\Facade;

/**
 * @mixin \App\Services\Masters\SubClusterService
 *
 * @method static \Illuminate\Support\Collection getAllDataWithRelations()
 * @method static void bulk(array $subClusters = [])
 * @method static \Illuminate\Bus\Batch instanceBulk(Illuminate\Bus\Batch $batch)
 *
 * @see \App\Services\Masters\SubClusterService
 */
class SubClusterService extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'sub_cluster_service';
    }
}
