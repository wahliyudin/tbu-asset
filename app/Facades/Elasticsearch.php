<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @mixin \App\Elasticsearch\Elasticsearch
 *
 * @method static \App\Elasticsearch\Elasticsearch setModel($classModel): \App\Elasticsearch\Elasticsearch
 *
 * @see \App\Elasticsearch\Elasticsearch
 */
class Elasticsearch extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'elasticsearch';
    }
}
