<?php

namespace App\Repositories\Assets;

use App\DataTransferObjects\Assets\AssetLeasingData;
use App\Models\Assets\Asset;
use App\Models\Assets\AssetLeasing;

class AssetLeasingRepository
{
    public function __construct(
        protected AssetLeasing $model
    ) {
    }

    public function updateOrCreateByAsset(AssetLeasingData $data, Asset $asset)
    {
        return $asset->leasing()->updateOrCreate([
            'asset_id' => $asset->getKey()
        ], [
            'dealer_id' => $data->dealer_id,
            'leasing_id' => $data->leasing_id,
            'harga_beli' => $data->hargaBeliToInt(),
            'jangka_waktu_leasing' => $data->jangka_waktu_leasing,
            'biaya_leasing' => $data->biayaToInt(),
            'legalitas' => $data->legalitas,
        ]);
    }

    public function delete(?AssetLeasing $assetLeasing)
    {
        return $assetLeasing?->delete();
    }
}