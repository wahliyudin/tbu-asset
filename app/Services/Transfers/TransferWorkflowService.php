<?php

namespace App\Services\Transfers;

use App\DataTransferObjects\Transfers\AssetTransferData;
use App\Enums\Workflows\Module;
use App\Enums\Workflows\Status;
use App\Facades\Elasticsearch;
use App\Models\Transfers\AssetTransfer;
use App\Services\Workflows\Workflow;
use Illuminate\Database\Eloquent\Model;

class TransferWorkflowService extends Workflow
{
    public static function setModel(AssetTransfer $assetTransfer)
    {
        return new self($assetTransfer, Module::TRANSFER);
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

    protected function changeStatus(Model $assetTransfer, Status $status)
    {
        $assetTransfer->load(['asset', 'workflows']);
        $data = AssetTransferData::from(array_merge($assetTransfer->toArray(), ['status' => $status->value]));
        return Elasticsearch::setModel(AssetTransfer::class)->updated($data);
    }
}
