<?php

namespace App\Jobs\Assets;

use App\Websockets\PusherBrodcast;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Bus;

class ImportCompleted implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        protected $batchId
    ) {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $batch = Bus::findBatch($this->batchId);
        PusherBrodcast::send('progress-channel', 'progress.assets.import', $batch->toArray());
    }
}
