<?php

namespace App\Services\Assets;

use App\DataTransferObjects\Assets\AssetDto;
use App\DataTransferObjects\Assets\AssetInsuranceDto;
use App\DataTransferObjects\Assets\AssetLeasingDto;
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
        return Asset::query()->get();
    }

    public function getDataForEdit(Asset $asset): array
    {
        $assetDto = AssetDto::fromModel($asset);
        $leasingDto = AssetLeasingDto::fromAsset($asset);
        $insuranceDto = AssetInsuranceDto::fromAsset($asset);
        return array_merge($assetDto->toArray(), $leasingDto->toArray(), $insuranceDto->toArray());
    }

    public function updateOrCreate(AssetRequest $request)
    {
        $asset = $this->assetRepository->updateOrCreate(AssetDto::fromRequest($request));
        $this->assetInsuranceRepository->updateOrCreateByAsset(AssetInsuranceDto::fromRequest($request), $asset);
        $this->assetLeasingRepository->updateOrCreateByAsset(AssetLeasingDto::fromRequest($request), $asset);
    }

    public function delete(Asset $asset)
    {
        $this->assetInsuranceRepository->delete($asset->insurance);
        $this->assetLeasingRepository->delete($asset->leasing);
        return $asset->delete();
    }
}
