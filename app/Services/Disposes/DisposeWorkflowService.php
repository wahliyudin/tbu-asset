<?php

namespace App\Services\Disposes;

use App\Enums\Workflows\Module;
use App\Models\Disposes\AssetDispose;
use App\Services\WorkflowService;
use Illuminate\Database\Eloquent\Model;

class DisposeWorkflowService extends WorkflowService
{
    protected static AssetDispose $dispose;

    public function __construct()
    {
        parent::__construct(self::$dispose, Module::DISPOSE);
    }

    public static function setModel(Model $model)
    {
        static::$dispose = $model;
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