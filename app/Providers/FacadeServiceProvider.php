<?php

namespace App\Providers;

use App\Elasticsearch\Elasticsearch;
use App\Elasticsearch\ElasticsearchBuilder;
use App\Services\Assets\AssetService;
use App\Services\Masters\CategoryService;
use App\Services\Masters\ClusterService;
use App\Services\Masters\LeasingService;
use App\Services\Masters\SubClusterService;
use App\Services\Masters\UnitService;
use App\Services\Masters\UomService;
use Illuminate\Support\ServiceProvider;

class FacadeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind('elasticsearch', Elasticsearch::class);
        $this->app->bind('asset_service', AssetService::class);
        $this->app->bind('category_service', CategoryService::class);
        $this->app->bind('cluster_service', ClusterService::class);
        $this->app->bind('leasing_service', LeasingService::class);
        $this->app->bind('sub_cluster_service', SubClusterService::class);
        $this->app->bind('unit_service', UnitService::class);
        $this->app->bind('uom_service', UomService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
