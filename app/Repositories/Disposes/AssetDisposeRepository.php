<?php

namespace App\Repositories\Disposes;

use App\DataTransferObjects\Disposes\AssetDisposeData;
use App\Facades\Elasticsearch;
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
            'status' => $data->status,
        ]);
    }

    public function deleteFromElasticsearch(AssetDispose $assetDispose)
    {
        $assetDisposeData = AssetDisposeData::from($assetDispose);
        return Elasticsearch::setModel(AssetDispose::class)->deleted($assetDisposeData);
    }

    public function sendToElasticsearch(AssetDispose $assetDispose, $key)
    {
        $assetDispose->load(['asset', 'workflows']);
        if ($key) {
            return Elasticsearch::setModel(AssetDispose::class)->updated(AssetDisposeData::from($assetDispose));
        }
        return Elasticsearch::setModel(AssetDispose::class)->created(AssetDisposeData::from($assetDispose));
    }

    public static function storeWorkflow()
    {
    }
}
