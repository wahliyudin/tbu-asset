<?php

namespace App\Services\Assets;

use App\Helpers\Helper;
use App\Models\Assets\Depreciation;
use Carbon\Carbon;

class AssetDepreciationService
{
    public static function store(array $data)
    {
        if (!isset($data['asset_id'])) {
            return null;
        }

        $depresiasi = Depreciation::query()->where('asset_id', $data['asset_id'])->first();

        if ($depresiasi) {
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

    public static function generate(int $month, int $price, string $date)
    {
        $date = Carbon::make($date);
        $result = [];
        $sisa = $price;
        for ($i = 0; $i < $month; $i++) {
            $depre = $price / $month;
            $sisa = $sisa - $depre;
            $result[] = [
                'date' => $date->translatedFormat('d F Y'),
                'depreciation' => Helper::formatRupiah($depre, true),
                'sisa' => Helper::formatRupiah($sisa, true)
            ];
            $date->addMonth();
        }
        return $result;
    }
}
