<?php

namespace App\Services\Masters;

use App\DataTransferObjects\Masters\CatalogData;
use App\Facades\Elasticsearch;
use App\Models\Masters\Catalog;

class CatalogService
{
    public function all($search = null)
    {
        return Elasticsearch::setModel(Catalog::class)->searchQueryString($search, 50)->all();
    }

    public function updateOrCreate(CatalogData $data)
    {
        $catalog = Catalog::query()->updateOrCreate([
            'id' => $data->getKey()
        ], [
            'unit_model' => $data->unit_model,
            'unit_type' => $data->unit_type,
            'seri' => $data->seri,
            'unit_class' => $data->unit_class,
            'brand' => $data->brand,
            'spesification' => $data->spesification,
        ]);
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
