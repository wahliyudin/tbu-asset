<?php

namespace App\Services\Assets;
use App\Models\Assets\AssetLeasing;
use App\Helpers\Helper;

class AssetLeasingService {

    public static function store(array $data){
        if(!isset($data['asset_id']) && !isset($data['dealer_id']) && !isset($data['leasing_id'])){
            return null;
        }

        $assetLeasing = AssetLeasing::query()->where('asset_id', $data['asset_id'])->first();

        if($assetLeasing){
            return $assetLeasing;
        }

        return AssetLeasing::query()->create([
            'asset_id' => $data['asset_id'],
            'dealer_id' => $data['dealer_id'],
            'suplier_dealer' => $data['suplier_dealer'],
            'leasing_id' => $data['leasing_id'],
            'harga_beli' => (int)$data['harga_beli'],
            'jangka_waktu_leasing' => $data['jangka_waktu_leasing'],
            'tanggal_awal_leasing' => $data['tanggal_awal_leasing'],
            'tanggal_akhir_leasing' => $data['tanggal_akhir_leasing'],
            'tanggal_perolehan' => $data['tanggal_perolehan'],
            'biaya_leasing' => (int)$data['biaya_leasing'],
            'legalitas' => $data['legalitas'],
        ]);

    }
}
