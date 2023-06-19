<?php

namespace App\Services\Masters;

use App\DataTransferObjects\Masters\CategoryDTO;
use App\Models\Masters\Category;

class CategoryService
{
    public function all()
    {
        return Category::query()->get();
    }

    public function updateOrCreate(CategoryDto $dto)
    {
        return Category::query()->updateOrCreate([
            'id' => $dto->key
        ], [
            'name' => $dto->name,
        ]);
    }

    public function delete(Category $category)
    {
        return $category->delete();
    }
}
