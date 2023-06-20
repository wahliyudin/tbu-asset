<?php

namespace App\Services\Cers;

use App\Enums\Workflows\Module;
use App\Models\Cers\Cer;
use App\Services\WorkflowService;
use Illuminate\Database\Eloquent\Model;

class CerWorkflowService extends WorkflowService
{
    protected static Cer $cer;

    public function __construct()
    {
        parent::__construct($this->cer, Module::CER);
    }

    public static function setModel(Model $model)
    {
        static::$cer = $model;
        return new static;
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
