<?php

namespace App\Repositories\Assets;

use App\DataTransferObjects\Assets\AssetLeasingDto;
use App\Models\Assets\Asset;
use App\Models\Assets\AssetLeasing;

class AssetLeasingRepository
{
    public function __construct(
        protected AssetLeasing $model
    ) {
    }

    public function updateOrCreateByAsset(AssetLeasingDto $dto, Asset $asset)
    {
        return $asset->leasing()->updateOrCreate([
            'asset_id' => $asset->getKey()
        ], [
            'dealer_id' => $dto->dealer_id,
            'leasing_id' => $dto->leasing_id,
            'harga_beli' => $dto->intHargaBeli(),
            'jangka_waktu_leasing' => $dto->jangka_waktu_leasing,
            'biaya_leasing' => $dto->intBiaya(),
            'legalitas' => $dto->legalitas,
        ]);
    }

    public function delete(?AssetLeasing $assetLeasing)
    {
        return $assetLeasing?->delete();
    }
}
