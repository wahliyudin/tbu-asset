<?php

namespace App\Jobs\Masters\Category;

use App\Facades\Masters\Category\CategoryService;
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
        protected array $categories
    ) {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        CategoryService::bulk($this->categories);
    }
}
