<?php

namespace App\Jobs\Masters\Uom;

use App\Facades\Masters\Uom\UomService;
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
        protected array $uoms
    ) {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        UomService::bulk($this->uoms);
    }
}
