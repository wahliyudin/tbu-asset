<?php

namespace App\Repositories\Assets;

use App\DataTransferObjects\Assets\AssetDto;
use App\Models\Assets\Asset;

class AssetRepository
{
    public function __construct(
        protected Asset $model
    ) {
    }

    public function updateOrCreate(AssetDto $dto)
    {
        return $this->model->query()->updateOrCreate([
            'id' => $dto->key
        ], [
            'kode' => $dto->kode,
            'unit_id' => $dto->unit_id,
            'sub_cluster_id' => $dto->sub_cluster_id,
            'member_name' => $dto->member_name,
            'pic' => $dto->pic,
            'activity' => $dto->activity,
            'asset_location' => $dto->asset_location,
            'kondisi' => $dto->kondisi,
            'uom' => $dto->uom,
            'quantity' => $dto->quantity,
            'tgl_bast' => $dto->tgl_bast,
            'hm' => $dto->hm,
            'pr_number' => $dto->pr_number,
            'po_number' => $dto->po_number,
            'gr_number' => $dto->gr_number,
            'remark' => $dto->remark,
            'status' => $dto->status,
        ]);
    }
}
