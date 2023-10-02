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

    public static function generate(int $month, string $date, int $price)
    {
        $date = Carbon::make($date);
        $result = [];
        $year = $month / 12;
        $depre = ($price) / $month;
        $akumulasi = $depre;
        $currentSisa = 0;
        for ($i = 0; $i < $month; $i++) {
            $sisa = round($price - $akumulasi);
            if ($date->format('Y-m') == now()->format('Y-m')) {
                $currentSisa = $sisa;
            }
            $result['result'][] = [
                'date' => $date->translatedFormat('d F Y'),
                'depreciation' => Helper::formatRupiah($depre, true),
                'sisa' => Helper::formatRupiah($sisa, true)
            ];
            $akumulasi = $depre + $akumulasi;
            $date->addMonth();
        }
        $result['current_sisa'] = $currentSisa;
        return $result;
    }
}
