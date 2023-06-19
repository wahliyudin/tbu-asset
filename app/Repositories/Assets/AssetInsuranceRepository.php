<?php

namespace App\Repositories\Assets;

use App\DataTransferObjects\Assets\AssetInsuranceDto;
use App\Models\Assets\Asset;
use App\Models\Assets\AssetInsurance;

class AssetInsuranceRepository
{
    public function __construct(
        protected AssetInsurance $model
    ) {
    }

    public function updateOrCreateByAsset(AssetInsuranceDto $dto, Asset $asset)
    {
        return $asset->insurance()->updateOrCreate([
            'asset_id' => $asset->getKey()
        ], [
            'jangka_waktu' => $dto->jangka_waktu,
            'biaya' => $dto->intBiaya(),
            'legalitas' => $dto->legalitas,
        ]);
    }
}
