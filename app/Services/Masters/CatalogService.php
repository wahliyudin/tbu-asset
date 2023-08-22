<?php

namespace App\Services\Masters;

use App\DataTransferObjects\Masters\CatalogData;
use App\Http\Requests\Masters\CatalogStoreRequest;
use App\Models\Masters\Catalog;

class CatalogService
{
    public function all()
    {
        return Catalog::query()->get();
    }

    public function updateOrCreate(CatalogStoreRequest $request)
    {
        $data = CatalogData::from($request->all());
        return Catalog::query()->updateOrCreate([
            'id' => $data->key
        ], $data->toArray());
    }

    public function delete(Catalog $catalog)
    {
        return $catalog->delete();
    }
}
