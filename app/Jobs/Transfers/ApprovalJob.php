<?php

namespace App\Jobs\Transfers;

use App\Models\Transfers\AssetTransfer;
use App\Services\Transfers\TransferWorkflowService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class ApprovalJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        protected string $view,
        protected AssetTransfer $transfer
    ) {
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        if ($this->view == 'emails.transfer.approv') {;
            $employee = TransferWorkflowService::setModel($this->transfer)->nextWorkflow()?->employee;
            $data['url'] = route('approvals.transfers.show', $this->transfer->getKey());
        } else {
            $employee = $this->transfer->employee;
            $data['url'] = route('asset-transfers.show', $this->transfer->getKey());
        }

        // $data['cc'] = [];
        // if ($this->view == 'emails.transfer.close') {
        //     $data['cc'] = ['marianti@tbu.co.id', 'junia@tbu.co.id'];
        // }

        $data['email'] = $employee->email_perusahaan;
        $data['title'] = "ASSET Alert System";

        $data['employee'] = $employee;
        $data['transfer'] = $this->transfer;

        Mail::send($this->view, $data, function ($message) use ($data) {
            $message->to($data["email"])
                ->subject($data["title"]);
        });
    }
}
