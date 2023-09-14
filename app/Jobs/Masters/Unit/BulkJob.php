<?php

namespace App\Jobs\Masters\Unit;

use App\Facades\Masters\Unit\UnitService;
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
        protected array $units
    ) {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        UnitService::bulk($this->units);
    }
}
