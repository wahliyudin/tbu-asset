<?php

namespace App\Services\Assets;

use App\DataTransferObjects\Assets\AssetUnitData;
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
            'unit_id' => $data['unit_id'],
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

    public function updateOrCreate(AssetUnitData $data)
    {
        return AssetUnit::query()->updateOrCreate([
            'id' => $data->key
        ], $data->toArray());
    }

    public function delete(?AssetUnit $assetUnit)
    {
        return $assetUnit?->delete();
    }

    public function getByIdAndLatest($id)
    {
        return AssetUnit::query()
            ->where('unit_id', $id)
            ->orderBy('kode', 'DESC')
            ->first();
    }
}
