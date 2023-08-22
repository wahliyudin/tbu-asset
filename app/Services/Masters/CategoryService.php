<?php

namespace App\Services\Masters;

use App\DataTransferObjects\Masters\CategoryData;
use App\Http\Requests\Masters\CategoryStoreRequest;
use App\Models\Masters\Category;

class CategoryService
{
    public function all()
    {
        return Category::query()->get();
    }

    public function updateOrCreate(CategoryStoreRequest $request)
    {
        $data = CategoryData::from($request->all());
        return Category::query()->updateOrCreate([
            'id' => $data->key
        ], $data->toArray());
    }

    public function delete(Category $category)
    {
        return $category->delete();
    }
}
