<?php

namespace App\Services\Transfers;

use App\Enums\Workflows\Module;
use App\Models\Transfers\AssetTransfer;
use App\Services\WorkflowService;
use Illuminate\Database\Eloquent\Model;

class TransferWorkflowService extends WorkflowService
{
    protected static AssetTransfer $transfer;

    public function __construct()
    {
        parent::__construct($this->transfer, Module::TRANSFER);
    }

    public static function setModel(Model $model)
    {
        static::$transfer = $model;
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
