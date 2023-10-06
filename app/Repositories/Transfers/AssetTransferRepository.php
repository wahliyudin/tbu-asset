<?php

namespace App\Repositories\Transfers;

use App\DataTransferObjects\Transfers\AssetTransferData;
use App\Facades\Elasticsearch;
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
            'old_location' => $data->old_location,
            'old_divisi' => $data->old_divisi,
            'old_department' => $data->old_department,
            'new_pic' => $data->new_pic,
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
        $assetTransferData = AssetTransferData::from($assetTransfer);
        return Elasticsearch::setModel(AssetTransfer::class)->deleted($assetTransferData);
    }

    public function sendToElasticsearch(AssetTransfer $assetTransfer, $key)
    {
        $assetTransfer->load(['asset', 'workflows']);
        if ($key) {
            return Elasticsearch::setModel(AssetTransfer::class)->updated(AssetTransferData::from($assetTransfer));
        }
        return Elasticsearch::setModel(AssetTransfer::class)->created(AssetTransferData::from($assetTransfer));
    }

    public static function storeWorkflow()
    {
    }
}
