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
        return AssetTransfer::query()->get();
    }

    public function updateOrCreate(AssetTransferData $data)
    {
        $this->assetTransferRepository->updateOrCreate($data);
    }

    public function delete(AssetTransfer $assetTransfer)
    {
        return $assetTransfer->delete();
    }
}