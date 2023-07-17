<?php

namespace App\Services\Masters;

use App\DataTransferObjects\Masters\CategoryData;
use App\Facades\Elasticsearch;
use App\Models\Masters\Category;

class CategoryService
{
    public function all($search = null)
    {
        return Elasticsearch::setModel(Category::class)->searchQueryString($search, 50)->all();
    }

    public function updateOrCreate(CategoryData $data)
    {
        $category = Category::query()->updateOrCreate([
            'id' => $data->getKey()
        ], [
            'name' => $data->name,
        ]);
        $this->sendToElasticsearch($category, $data->getKey());
    }

    public function delete(Category $category)
    {
        Elasticsearch::setModel(Category::class)->deleted(CategoryData::from($category));
        return $category->delete();
    }

    public function getDataForEdit($id): array
    {
        $asset = Elasticsearch::setModel(Category::class)->find($id)->asArray();
        return $asset['_source'];
    }

    private function sendToElasticsearch(Category $category, $key)
    {
        $category->load(['clusters.subClusters.subClusterItems']);
        if ($key) {
            return Elasticsearch::setModel(Category::class)->updated(CategoryData::from($category));
        }
        return Elasticsearch::setModel(Category::class)->created(CategoryData::from($category));
    }
}
