<?php

namespace App\Services\Masters;

use App\DataTransferObjects\Masters\CategoryData;
use App\Models\Masters\Category;

class CategoryService
{
    public function all()
    {
        return Category::query()->get();
    }

    public function updateOrCreate(CategoryData $data)
    {
        return Category::query()->updateOrCreate([
            'id' => $data->key
        ], [
            'name' => $data->name,
        ]);
    }

    public function delete(Category $category)
    {
        return $category->delete();
    }
}