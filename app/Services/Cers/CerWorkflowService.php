<?php

namespace App\Services\Cers;

use App\DataTransferObjects\Cers\CerData;
use App\Enums\Workflows\Module;
use App\Enums\Workflows\Status;
use App\Facades\Elasticsearch;
use App\Helpers\ProjectHelper;
use App\Jobs\Cers\ApprovalJob;
use App\Models\Cers\Cer;
use App\Services\Workflows\Workflow;
use Illuminate\Database\Eloquent\Model;

class CerWorkflowService extends Workflow
{
    public static function setModel(Cer $cer)
    {
        $module = ProjectHelper::hasHeadOffice($cer->employee?->position?->project) ? Module::CER_HO : Module::CER_SITE;
        return new self($cer, $module);
    }

    protected function handleStoreWorkflow()
    {
    }

    protected function handleIsLastAndApprov()
    {
        dispatch(new ApprovalJob('emails.cer.close', $this->model));
    }

    protected function handleIsNotLastAndApprov()
    {
        dispatch(new ApprovalJob('emails.cer.approv', $this->model));
    }

    protected function handleIsRejected()
    {
        dispatch(new ApprovalJob('emails.cer.reject', $this->model));
    }

    protected function changeStatus(Model $cer, Status $status)
    {
        $cer->load(['items', 'workflows']);
        $data = CerData::from(array_merge($cer->toArray(), ['status' => $status->value]));
        return Elasticsearch::setModel(Cer::class)->updated($data);
    }
}
