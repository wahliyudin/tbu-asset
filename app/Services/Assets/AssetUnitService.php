<?php

namespace App\Services\Assets;

use App\Models\Assets\AssetUnit;

class AssetUnitService
{
    public static function store(array $data)
    {
        if (!isset($data['kode'])) {
            return null;
        }

        $depresiasi = AssetUnit::query()->where('kode', $data['kode'])->first();

        if ($depresiasi) {
            return $depresiasi;
        }

        return AssetUnit::query()->create([
            'kode' => $data['kode'],
            'type' => $data['type'],
            'seri' => $data['seri'],
            'class' => $data['class'],
            'brand' => $data['brand'],
            'serial_number' => $data['serial_number'],
            'spesification' => $data['spesification'],
            'tahun_pembuatan' => $data['tahun_pembuatan'],
            'kelengkapan_tambahan' => $data['kelengkapan_tambahan'],
        ]);
    }
}
