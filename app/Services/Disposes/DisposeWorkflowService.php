<?php

namespace App\Services\Disposes;

use App\Enums\Workflows\Module;
use App\Models\Disposes\AssetDispose;
use App\Services\Workflows\Workflow;

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
}