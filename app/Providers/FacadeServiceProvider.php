<?php

namespace App\Providers;

use App\Elasticsearch\Elasticsearch;
use App\Elasticsearch\ElasticsearchBuilder;
use App\Kafka\Message;
use App\Repositories\Transfers\AssetTransferRepository;
use App\Services\API\TXIS\BudgetService;
use App\Services\Assets\AssetService;
use App\Services\HRIS\EmployeeService;
use App\Services\Masters\CategoryService;
use App\Services\Masters\ClusterService;
use App\Services\Masters\LeasingService;
use App\Services\Masters\SubClusterService;
use App\Services\Masters\UnitService;
use App\Services\Masters\UomService;
use App\Services\Transfers\AssetTransferService;
use App\Websockets\Pusher\PusherBrodcast;
use Illuminate\Support\ServiceProvider;

class FacadeServiceProvider extends ServiceProvider
{
    protected $facades = [
        'elasticsearch' => Elasticsearch::class,
        'pusher_websocket' => PusherBrodcast::class,
        'asset_service' => AssetService::class,
        'category_service' => CategoryService::class,
        'cluster_service' => ClusterService::class,
        'leasing_service' => LeasingService::class,
        'sub_cluster_service' => SubClusterService::class,
        'unit_service' => UnitService::class,
        'uom_service' => UomService::class,
        'employee_service' => EmployeeService::class,
        'asset_transfer_service' => AssetTransferService::class,
        'asset_transfer_repository' => AssetTransferRepository::class,
        'txis_budget_service' => BudgetService::class,
        'kafka_message' => Message::class,
    ];
    /**
     * Register services.
     */
    public function register(): void
    {
        foreach ($this->facades as $abstract => $concrete) {
            $this->app->bind($abstract, $concrete);
        }
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
