<?php

namespace App\Services\Cers;

use App\Enums\Workflows\Module;
use App\Models\Cers\Cer;
use App\Services\Workflows\Workflow;

class CerWorkflowService extends Workflow
{
    public static function setModel(Cer $cer)
    {
        return new self($cer, Module::CER);
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