<?php

namespace App\Repositories\Cers;

use App\DataTransferObjects\Cers\CerData;
use App\Models\Cers\Cer;

class CerRepository
{
    public function __construct(
        protected Cer $model
    ) {
    }

    public function updateOrCreate(CerData $data)
    {
        return $this->model->query()->updateOrCreate([
            'id' => $data->id
        ], [
            'no_cer' => $data->no_cer,
            'nik' => $data->nik,
            'type_budget' => $data->type_budget,
            'budget_ref' => $data->budget_ref,
            'peruntukan' => $data->peruntukan,
            'tgl_kebutuhan' => $data->tgl_kebutuhan,
            'justifikasi' => $data->justifikasi,
            'sumber_pendanaan' => $data->sumber_pendanaan,
            'cost_analyst' => $data->cost_analyst,
        ]);
    }

    public static function storeWorkflow()
    {
    }
}