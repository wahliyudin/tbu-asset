<?php

namespace App\Services\Transfers;

use App\DataTransferObjects\Transfers\AssetTransferData;
use App\Http\Requests\Transfers\AssetTransferRequest;
use App\Models\Transfers\AssetTransfer;
use App\Repositories\Transfers\AssetTransferRepository;

class AssetTransferService
{
    public function __construct(
        protected AssetTransferRepository $assetTransferRepository
    ) {
    }

    public function all()
    {
        return AssetTransfer::query()->with('asset')->get();
    }

    public function allToAssetTransferData()
    {
        return AssetTransferData::collection($this->all())->toCollection();
    }

    public function updateOrCreate(AssetTransferRequest $request)
    {
        $data = AssetTransferData::from($request->all());
        $assetTransfer = $this->assetTransferRepository->updateOrCreate($data);
        TransferWorkflowService::setModel($assetTransfer)->store();
    }

    public function delete(AssetTransfer $assetTransfer)
    {
        $assetTransfer->workflows()->delete();
        return $assetTransfer->delete();
    }
}
