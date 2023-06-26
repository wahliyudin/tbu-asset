<?php

namespace App\Repositories\Cers;

use App\DataTransferObjects\Cers\CerDto;
use App\Models\Cers\Cer;

class CerRepository
{
    public function __construct(
        protected Cer $model
    ) {
    }

    public function updateOrCreate(CerDto $dto)
    {
        return $this->model->query()->updateOrCreate([
            'id' => $dto->key
        ], [
            'no_cer' => $dto->no_cer,
            'nik' => $dto->nik,
            'type_budget' => $dto->type_budget,
            'budget_ref' => $dto->budget_ref,
            'peruntukan' => $dto->peruntukan,
            'tgl_kebutuhan' => $dto->tgl_kebutuhan,
            'justifikasi' => $dto->justifikasi,
            'sumber_pendanaan' => $dto->sumber_pendanaan,
            'cost_analyst' => $dto->cost_analyst,
        ]);
    }

    public static function storeWorkflow()
    {
    }
}