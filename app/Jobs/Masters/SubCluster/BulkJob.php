<?php

namespace App\Jobs\Masters\SubCluster;

use App\Facades\Masters\SubCluster\SubClusterService;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class BulkJob implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        protected array $subClusters
    ) {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        SubClusterService::bulk($this->subClusters);
    }
}
