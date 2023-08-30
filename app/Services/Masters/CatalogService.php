<?php

namespace App\Services\Masters;

use App\DataTransferObjects\Masters\CatalogData;
use App\Http\Requests\Masters\CatalogStoreRequest;
use App\Facades\Elasticsearch;
use App\Models\Masters\Catalog;

class CatalogService
{
    public function all($search = null)
    {
        return Elasticsearch::setModel(Catalog::class)->searchMultiMatch($search, 50)->all();
    }

    public function updateOrCreate(CatalogStoreRequest $request)
    {
        $data = CatalogData::from($request->all());
        $catalog = Catalog::query()->updateOrCreate([
            'id' => $data->key
        ], $data->toArray());
        $this->sendToElasticsearch($catalog, $data->getKey());
        return $catalog;
    }

    public function delete(Catalog $catalog)
    {
        Elasticsearch::setModel(Catalog::class)->deleted(CatalogData::from($catalog));
        return $catalog->delete();
    }

    public function getDataForEdit($id): array
    {
        $asset = Elasticsearch::setModel(Catalog::class)->find($id)->asArray();
        return $asset['_source'];
    }

    private function sendToElasticsearch(Catalog $catalog, $key)
    {
        if ($key) {
            return Elasticsearch::setModel(Catalog::class)->updated(CatalogData::from($catalog));
        }
        return Elasticsearch::setModel(Catalog::class)->created(CatalogData::from($catalog));
    }
}
