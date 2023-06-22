<?php

namespace App\Services\Transfers;

use App\DataTransferObjects\Transfers\AssetTransferDto;
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

    public function updateOrCreate(AssetTransferRequest $request)
    {
        $this->assetTransferRepository->updateOrCreate(AssetTransferDto::fromRequest($request));
    }

    public function delete(AssetTransfer $assetTransfer)
    {
        return $assetTransfer->delete();
    }
}