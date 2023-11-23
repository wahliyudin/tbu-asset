<?php

namespace App\Repositories\Transfers;

use App\DataTransferObjects\Transfers\AssetTransferData;
use App\Facades\Elasticsearch;
use App\Kafka\Enums\Nested;
use App\Kafka\Enums\Topic;
use App\Kafka\Facades\Message;
use App\Models\Transfers\AssetTransfer;

class AssetTransferRepository
{
    public function updateOrCreate(AssetTransferData $data)
    {
        return AssetTransfer::query()->updateOrCreate([
            'id' => $data->id
        ], [
            'no_transaksi' => $data->no_transaksi,
            'nik' => $data->nik,
            'asset_id' => $data->asset_id,
            'old_pic' => $data->old_pic,
            'old_project' => $data->old_project,
            'old_location' => $data->old_location,
            'old_divisi' => $data->old_divisi,
            'old_department' => $data->old_department,
            'new_pic' => $data->new_pic,
            'new_project' => $data->new_project,
            'new_location' => $data->new_location,
            'new_divisi' => $data->new_divisi,
            'new_department' => $data->new_department,
            'request_transfer_date' => $data->request_transfer_date,
            'justifikasi' => $data->justifikasi,
            'remark' => $data->remark,
            'transfer_date' => $data->transfer_date,
            'status_transfer' => $data->status_transfer,
            'status' => $data->status,
        ]);
    }

    public function deleteFromElasticsearch(AssetTransfer $assetTransfer)
    {
        return Message::deleted(Topic::ASSET_TRANSFER, 'id', $assetTransfer->getKey(), Nested::ASSET_TRANSFER);
    }

    public function sendToElasticsearch(AssetTransfer $assetTransfer, $key)
    {
        $assetTransfer->load(['asset', 'workflows', 'statusTransfer']);
        return Message::updateOrCreate(Topic::ASSET_TRANSFER, $assetTransfer->getKey(), $assetTransfer->toArray());
    }

    public static function storeWorkflow()
    {
    }
}
