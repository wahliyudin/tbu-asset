<?php

namespace App\Providers;

use App\Elasticsearch\Elasticsearch;
use App\Elasticsearch\ElasticsearchBuilder;
use App\Services\Assets\AssetService;
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
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
