<?php

namespace App\Services\Masters;

use App\DataTransferObjects\Masters\CategoryData;
use App\Http\Requests\Masters\CategoryStoreRequest;
use App\Facades\Elasticsearch;
use App\Models\Masters\Category;
use Illuminate\Support\Facades\DB;

class CategoryService
{
    public function all($search = null, $length = 50)
    {
        return Elasticsearch::setModel(Category::class)->searchMultiMatch($search, $length)->all();
    }

    public static function dataForSelect(...$others)
    {
        return Category::select(array_merge(['id', 'name'], $others))->get();
    }

    public function updateOrCreate(CategoryStoreRequest $request)
    {
        $data = CategoryData::from($request->all());
        return DB::transaction(function () use ($data) {
            $category = Category::query()->updateOrCreate([
                'id' => $data->key
            ], $data->toArray());
            $this->sendToElasticsearch($category, $data->getKey());
            return $category;
        });
    }

    public static function store(array $data)
    {
        if (!isset($data['id']) || !isset($data['name'])) {
            return null;
        }
        if ($category = Category::query()->where('name', trim($data['name']))->first()) {
            return $category;
        }
        return Category::query()->create([
            'id' => $data['id'],
            'name' => $data['name']
        ]);
    }

    public function delete(Category $category)
    {
        return DB::transaction(function () use ($category) {
            Elasticsearch::setModel(Category::class)->deleted(CategoryData::from($category));
            return $category->delete();
        });
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
