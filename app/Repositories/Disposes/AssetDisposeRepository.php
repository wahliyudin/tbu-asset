<?php

namespace App\Repositories\Disposes;

use App\DataTransferObjects\Disposes\AssetDisposeData;
use App\Models\Disposes\AssetDispose;

class AssetDisposeRepository
{
    public function updateOrCreate(AssetDisposeData $data)
    {
        return AssetDispose::query()->updateOrCreate([
            'id' => $data->id
        ], [
            'asset_id' => $data->asset_id,
            'no_dispose' => $data->no_dispose,
            'nik' => $data->nik,
            'nilai_buku' => $data->nailaiBukuToInt(),
            'est_harga_pasar' => $data->estHargaPasarToInt(),
            'notes' => $data->notes,
            'justifikasi' => $data->justifikasi,
            'pelaksanaan' => $data->pelaksanaan,
            'remark' => $data->remark,
        ]);
    }

    public static function storeWorkflow()
    {
    }
}
