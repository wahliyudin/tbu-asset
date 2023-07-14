<?php

namespace App\Providers;

use App\Elasticsearch\Elasticsearch;
use App\Elasticsearch\ElasticsearchBuilder;
use Illuminate\Support\ServiceProvider;

class FacadeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind('elasticsearch', function ($app) {
            // return new ElasticsearchBuilder;
            return new Elasticsearch;
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
