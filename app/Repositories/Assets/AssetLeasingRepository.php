<?php

namespace App\Repositories\Assets;

use App\DataTransferObjects\Assets\AssetLeasingData;
use App\Models\Assets\Asset;
use App\Models\Assets\AssetLeasing;

class AssetLeasingRepository
{
    public function updateOrCreateByAsset(AssetLeasingData $data, Asset $asset)
    {
        return $asset->leasing()->updateOrCreate([
            'asset_id' => $asset->getKey()
        ], [
            'dealer_id' => $data->dealer_id,
            'suplier_dealer' => $data->suplier_dealer,
            'leasing_id' => $data->leasing_id,
            'harga_beli' => $data->hargaBeliToInt(),
            'jangka_waktu_leasing' => $data->jangka_waktu_leasing,
            'tanggal_awal_leasing' => $data->tanggal_awal_leasing,
            'tanggal_akhir_leasing' => $data->tanggal_akhir_leasing,
            'biaya_leasing' => $data->biayaToInt(),
            'legalitas' => $data->legalitas,
            'tanggal_perolehan' => $data->tanggal_perolehan,
        ]);
    }

    public function delete(?AssetLeasing $assetLeasing)
    {
        return $assetLeasing?->delete();
    }
}
