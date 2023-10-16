<?php

namespace App\Jobs\Transfers;

use App\Facades\API\TXIS\BudgetService;
use App\Models\Transfers\AssetTransfer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class BudgetMutationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        protected string $view,
        protected AssetTransfer $transfer,
        protected $budgets,
    ) {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $data['transfer'] = $this->transfer;
        $data['histories'] = $this->budgets;

        $data['email'] = 'finance@tbu.co.id';
        $data['title'] = "Notification Budget Mutatation FROM Asset Transfer";

        Mail::send($this->view, $data, function ($message) use ($data) {
            $message->to($data["email"])
                ->subject($data["title"]);
        });
    }
}
