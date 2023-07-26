<?php

namespace App\Jobs\Assets;

use App\Events\ImportEvent;
use App\Imports\Assets\AssetImport;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class ImportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        protected $file
    ) {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Excel::import(new AssetImport(), $this->file);
        Storage::delete($this->file);
        event(new ImportEvent([
            'status' => 200,
            'title' => 'Import finish',
            'message' => 'Silahkan reload halaman!'
        ]));
    }

    public function failed(\Exception $exception)
    {
        event(new ImportEvent([
            'status' => 500,
            'title' => 'Error',
            'message' => $exception->getMessage()
        ]));
    }
}
