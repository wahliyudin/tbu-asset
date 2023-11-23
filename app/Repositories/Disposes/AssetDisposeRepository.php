<?php

namespace App\Repositories\Disposes;

use App\DataTransferObjects\Disposes\AssetDisposeData;
use App\Facades\Elasticsearch;
use App\Kafka\Enums\Nested;
use App\Kafka\Enums\Topic;
use App\Kafka\Facades\Message;
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
        return Message::deleted(Topic::ASSET_DISPOSE, 'id', $assetDispose->getKey(), Nested::ASSET_DISPOSE);
    }

    public function sendToElasticsearch(AssetDispose $assetDispose, $key)
    {
        $assetDispose->load(['asset', 'workflows']);
        return Message::updateOrCreate(Topic::ASSET_DISPOSE, $assetDispose->getKey(), $assetDispose->toArray());
    }

    public static function storeWorkflow()
    {
    }
}
