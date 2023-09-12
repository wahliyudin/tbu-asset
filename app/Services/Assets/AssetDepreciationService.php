<?php 

namespace App\Services\Assets;
use App\Models\Assets\Depreciation;

class AssetDepreciationService 
{
    public static function store(array $data){
        if(!isset($data['asset_id'])){
            return null;
        }

        $depresiasi = Depreciation::query()->where('asset_id', $data['asset_id'])->first();

        if($depresiasi){
            return $depresiasi;
        }

        return Depreciation::query()->create([
            'asset_id' => $data['asset_id'],
            'masa_pakai' => (int)$data['masa_pakai'],
            'umur_asset' => (int)$data['umur_asset'],
            'umur_pakai' => (int)$data['umur_pakai'],
            'depresiasi' => (int)$data['depresiasi'],
            'sisa' => (int)$data['sisa'],
        ]);

    }
    
}
