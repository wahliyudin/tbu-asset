<?php

namespace App\Repositories\Disposes;

use App\DataTransferObjects\Disposes\AssetDisposeDto;
use App\Models\Disposes\AssetDispose;

class AssetDisposeRepository
{
    public function __construct(
        protected AssetDispose $model
    ) {
    }

    public function updateOrCreate(AssetDisposeDto $dto)
    {
        return $this->model->query()->updateOrCreate([
            'id' => $dto->key
        ], [
            'no_dispose' => $dto->no_dispose,
            'nik' => $dto->nik,
            'nilai_buku' => $dto->nilai_buku,
            'est_harga_pasar' => $dto->est_harga_pasar,
            'notes' => $dto->notes,
            'justifikasi' => $dto->justifikasi,
            'remark' => $dto->remark,
        ]);
    }

    public static function storeWorkflow()
    {
    }
}