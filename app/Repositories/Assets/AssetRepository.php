<?php

namespace App\Repositories\Assets;

use App\DataTransferObjects\Assets\AssetData;
use App\Models\Assets\Asset;

class AssetRepository
{
    public function __construct(
        protected Asset $model
    ) {
    }

    public function updateOrCreate(AssetData $data)
    {
        return $this->model->query()->updateOrCreate([
            'id' => $data->getKey()
        ], [
            'kode' => $data->kode,
            'unit_id' => $data->unit_id,
            'sub_cluster_id' => $data->sub_cluster_id,
            'member_name' => $data->member_name,
            'pic' => $data->pic,
            'activity' => $data->activity,
            'asset_location' => $data->asset_location,
            'kondisi' => $data->kondisi,
            'uom' => $data->uom,
            'quantity' => $data->quantity,
            'tgl_bast' => $data->tgl_bast,
            'hm' => $data->hm,
            'pr_number' => $data->pr_number,
            'po_number' => $data->po_number,
            'gr_number' => $data->gr_number,
            'remark' => $data->remark,
            'status' => $data->status,
        ]);
    }
}
