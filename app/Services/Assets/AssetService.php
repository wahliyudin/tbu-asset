<?php

namespace App\Services\Assets;

use App\DataTransferObjects\Assets\AssetData;
use App\DataTransferObjects\Assets\AssetInsuranceData;
use App\DataTransferObjects\Assets\AssetLeasingData;
use App\Enums\Asset\Status;
use App\Http\Requests\Assets\AssetRequest;
use App\Models\Assets\Asset;
use App\Repositories\Assets\AssetInsuranceRepository;
use App\Repositories\Assets\AssetLeasingRepository;
use App\Repositories\Assets\AssetRepository;

class AssetService
{
    public function __construct(
        protected AssetRepository $assetRepository,
        protected AssetInsuranceRepository $assetInsuranceRepository,
        protected AssetLeasingRepository $assetLeasingRepository,
    ) {
    }

    public function all()
    {
        return Asset::query()->with(['leasing', 'insurance'])->get();
    }

    public function getById($id)
    {
        return Asset::query()->find($id);
    }

    public function getByStatus(Status $status)
    {
        return Asset::query()->where('status', $status)->get();
    }

    public function getDataForEdit(Asset $asset): array
    {
        $asset->loadMissing(['insurance', 'leasing']);
        $assetDto = AssetData::from($asset);
        return $assetDto->toArray();
    }

    public function updateOrCreate(AssetRequest $request)
    {
        $asset = $this->assetRepository->updateOrCreate(AssetData::from($request->all()));
        $this->assetInsuranceRepository->updateOrCreateByAsset(AssetInsuranceData::fromRequest($request), $asset);
        $this->assetLeasingRepository->updateOrCreateByAsset(AssetLeasingData::fromRequest($request), $asset);
    }

    public function delete(Asset $asset)
    {
        $this->assetInsuranceRepository->delete($asset->insurance);
        $this->assetLeasingRepository->delete($asset->leasing);
        return $asset->delete();
    }
}