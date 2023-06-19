<?php

namespace App\Services\Masters;

use App\DataTransferObjects\Masters\CatalogDTO;
use App\Masters\Models\Catalog;

class CatalogService
{
    public function all()
    {
        return Catalog::query()->get();
    }

    public function updateOrCreate(CatalogDto $dto)
    {
        return Catalog::query()->updateOrCreate([
            'id' => $dto->key
        ], [
            'unit_model' => $dto->unit_model,
            'unit_type' => $dto->unit_type,
            'seri' => $dto->seri,
            'unit_class' => $dto->unit_class,
            'brand' => $dto->brand,
            'spesification' => $dto->spesification,
        ]);
    }

    public function delete(Catalog $catalog)
    {
        return $catalog->delete();
    }
}
