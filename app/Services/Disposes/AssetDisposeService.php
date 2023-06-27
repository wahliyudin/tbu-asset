<?php

namespace App\Services\Disposes;

use App\DataTransferObjects\Disposes\AssetDisposeDto;
use App\Http\Requests\Disposes\AssetDisposeRequest;
use App\Models\Disposes\AssetDispose;
use App\Repositories\Disposes\AssetDisposeRepository;

class AssetDisposeService
{
    public function __construct(
        protected AssetDisposeRepository $assetDisposeRepository
    ) {
    }

    public function all()
    {
        return AssetDispose::query()->get();
    }

    public function updateOrCreate(AssetDisposeRequest $request)
    {
        $dto = AssetDisposeDto::fromRequest($request);
        $assetDispose = $this->assetDisposeRepository->updateOrCreate($dto);
        $assetDispose->workflows()->delete();
        DisposeWorkflowService::setModel($assetDispose)->store();
    }

    public function delete(AssetDispose $assetDispose)
    {
        $assetDispose->workflows()->delete();
        return $assetDispose->delete();
    }
}
