<?php

namespace App\Repositories\Transfers;

use App\DataTransferObjects\Transfers\AssetTransferDto;
use App\Models\Transfers\AssetTransfer;

class AssetTransferRepository
{
    public function __construct(
        protected AssetTransfer $model
    ) {
    }

    public function updateOrCreate(AssetTransferDto $dto)
    {
        return $this->model->query()->updateOrCreate([
            'id' => $dto->key
        ], [
            'no_transaksi' => $dto->no_transaksi,
            'nik' => $dto->nik,
            'old_pic' => $dto->old_pic,
            'old_location' => $dto->old_location,
            'old_divisi' => $dto->old_divisi,
            'old_department' => $dto->old_department,
            'new_pic' => $dto->new_pic,
            'new_location' => $dto->new_location,
            'new_divisi' => $dto->new_divisi,
            'new_department' => $dto->new_department,
            'request_transfer_date' => $dto->request_transfer_date,
            'justifikasi' => $dto->justifikasi,
            'remark' => $dto->remark,
            'transfer_date' => $dto->transfer_date,
        ]);
    }

    public static function storeWorkflow()
    {
    }
}