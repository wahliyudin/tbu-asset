<?php

namespace App\Services\Transfers;

use App\Enums\Transfers\Transfer\Status as TransferStatus;
use App\Enums\Workflows\Module;
use App\Facades\Transfers\AssetTransferRepository;
use App\Facades\Transfers\AssetTransferService;
use App\Jobs\Transfers\ApprovalJob;
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
        dispatch(new ApprovalJob('emails.transfers.approv', $this->model));
    }

    protected function handleIsLastAndApprov()
    {
        AssetTransferService::statusTransfer($this->model, TransferStatus::PROCESS);
        dispatch(new ApprovalJob('emails.transfers.close', $this->model));
    }

    protected function handleIsNotLastAndApprov()
    {
        dispatch(new ApprovalJob('emails.transfers.approv', $this->model));
    }

    protected function handleIsRejected()
    {
        dispatch(new ApprovalJob('emails.transfers.reject', $this->model));
    }

    protected function handleChanges(Model $assetTransfer)
    {
        return AssetTransferRepository::sendToElasticsearch($assetTransfer, $assetTransfer->getKey());
    }
}
