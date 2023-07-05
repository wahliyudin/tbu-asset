<?php

namespace App\Repositories\Transfers;

use App\DataTransferObjects\Transfers\AssetTransferData;
use App\Models\Transfers\AssetTransfer;

class AssetTransferRepository
{
    public function __construct(
        protected AssetTransfer $model
    ) {
    }

    public function updateOrCreate(AssetTransferData $data)
    {
        return $this->model->query()->updateOrCreate([
            'id' => $data->id
        ], [
            'no_transaksi' => $data->no_transaksi,
            'nik' => $data->nik,
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
        ]);
    }

    public static function storeWorkflow()
    {
    }
}