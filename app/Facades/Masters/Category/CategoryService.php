<?php

namespace App\Facades\Masters\Category;

use Illuminate\Support\Facades\Facade;

/**
 * @mixin \App\Services\Masters\CategoryService
 *
 * @method static \Illuminate\Support\Collection getAllDataWithRelations()
 * @method static void bulk(array $categories = [])
 * @method static \Illuminate\Bus\Batch instanceBulk(Illuminate\Bus\Batch $batch)
 *
 * @see \App\Services\Masters\CategoryService
 */
class CategoryService extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'category_service';
    }
}
