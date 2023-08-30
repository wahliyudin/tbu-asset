<?php

namespace App\Services\Disposes;

use App\Enums\Workflows\Module;
use App\Enums\Workflows\Status;
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
    }

    protected function handleIsNotLastAndApprov()
    {
    }

    protected function handleIsRejected()
    {
    }

    protected function changeStatus(Model $dispose, Status $status)
    {
    }
}
