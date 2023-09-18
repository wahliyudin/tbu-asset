<?php

namespace App\Services\Disposes;

use App\DataTransferObjects\Disposes\AssetDisposeData;
use App\Enums\Workflows\Module;
use App\Enums\Workflows\Status;
use App\Facades\Elasticsearch;
use App\Jobs\Disposes\ApprovalJob;
use App\Models\Disposes\AssetDispose;
use App\Services\Workflows\Workflow;
use Illuminate\Database\Eloquent\Model;

class DisposeWorkflowService extends Workflow
{
    public static function setModel(AssetDispose $assetDispose)
    {
        return new self($assetDispose, Module::DISPOSE);
    }

    protected function handleStoreWorkflow()
    {
    }

    protected function handleIsLastAndApprov()
    {
        dispatch(new ApprovalJob('emails.dispose.close', $this->model));
    }

    protected function handleIsNotLastAndApprov()
    {
        dispatch(new ApprovalJob('emails.dispose.approv', $this->model));
    }

    protected function handleIsRejected()
    {
        dispatch(new ApprovalJob('emails.dispose.reject', $this->model));
    }

    protected function changeStatus(Model $assetDispose, Status $status)
    {
        $assetDispose->load(['asset', 'workflows']);
        $data = AssetDisposeData::from(array_merge($assetDispose->toArray(), ['status' => $status->value]));
        return Elasticsearch::setModel(AssetDispose::class)->updated($data);
    }
}
