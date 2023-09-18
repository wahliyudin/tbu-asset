<?php

namespace App\Jobs\Disposes;

use App\Models\Disposes\AssetDispose;
use App\Services\Disposes\DisposeWorkflowService;
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
        protected AssetDispose $dispose
    ) {
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        if ($this->view == 'emails.dispose.approv') {;
            $employee = DisposeWorkflowService::setModel($this->dispose)->currentWorkflow()?->employee;
            $data['url'] = route('approvals.disposes.show', $this->dispose->getKey());
        } else {
            $employee = $this->dispose->employee;
            $data['url'] = route('asset-disposes.show', $this->dispose->getKey());
        }

        // $data['cc'] = [];
        // if ($this->view == 'emails.dispose.close') {
        //     $data['cc'] = ['marianti@tbu.co.id', 'junia@tbu.co.id'];
        // }

        $data['email'] = $employee->email_perusahaan;
        $data['title'] = "ASSET Alert System";

        $data['employee'] = $employee;
        $data['dispose'] = $this->dispose;

        Mail::send($this->view, $data, function ($message) use ($data) {
            $message->to($data["email"])
                ->subject($data["title"]);
        });
    }
}
