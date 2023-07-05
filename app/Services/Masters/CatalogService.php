<?php

namespace App\Services\Masters;

use App\DataTransferObjects\Masters\CatalogData;
use App\Models\Masters\Catalog;

class CatalogService
{
    public function all()
    {
        return Catalog::query()->get();
    }

    public function updateOrCreate(CatalogData $data)
    {
        return Catalog::query()->updateOrCreate([
            'id' => $data->key
        ], [
            'unit_model' => $data->unit_model,
            'unit_type' => $data->unit_type,
            'seri' => $data->seri,
            'unit_class' => $data->unit_class,
            'brand' => $data->brand,
            'spesification' => $data->spesification,
        ]);
    }

    public function delete(Catalog $catalog)
    {
        return $catalog->delete();
    }
}