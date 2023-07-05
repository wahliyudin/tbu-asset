<?php

namespace App\Repositories\Assets;

use App\DataTransferObjects\Assets\AssetInsuranceData;
use App\Models\Assets\Asset;
use App\Models\Assets\AssetInsurance;

class AssetInsuranceRepository
{
    public function __construct(
        protected AssetInsurance $model
    ) {
    }

    public function updateOrCreateByAsset(AssetInsuranceData $data, Asset $asset)
    {
        return $asset->insurance()->updateOrCreate([
            'asset_id' => $asset->getKey()
        ], [
            'jangka_waktu' => $data->jangka_waktu,
            'biaya' => $data->biayaToInt(),
            'legalitas' => $data->legalitas,
        ]);
    }

    public function delete(?AssetInsurance $assetInsurance)
    {
        return $assetInsurance?->delete();
    }
}