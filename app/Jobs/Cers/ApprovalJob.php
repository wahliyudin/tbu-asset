<?php

namespace App\Jobs\Cers;

use App\Models\Cers\Cer;
use App\Services\Cers\CerWorkflowService;
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
        protected Cer $cer
    ) {
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        if ($this->view == 'emails.cer.approv') {;
            $employee = CerWorkflowService::setModel($this->cer)->currentWorkflow()?->employee;
            $data['url'] = route('approvals.cers.show', $this->cer->getKey());
        } else {
            $employee = $this->cer->employee;
            $data['url'] = route('asset-requests.show', $this->cer->getKey());
        }

        // $data['cc'] = [];
        // if ($this->view == 'emails.cer.close') {
        //     $data['cc'] = ['marianti@tbu.co.id', 'junia@tbu.co.id'];
        // }

        $data['email'] = $employee->email_perusahaan;
        $data['title'] = "ASSET Alert System";

        $data['employee'] = $employee;
        $data['cer'] = $this->cer;

        Mail::send($this->view, $data, function ($message) use ($data) {
            $message->to($data["email"])
                ->subject($data["title"]);
        });
    }
}
