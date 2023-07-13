<?php

namespace App\Elasticsearch\Traits;

use App\Elasticsearch\Contracts\ModelElasticsearchInterface;
use Exception;
use Illuminate\Database\Eloquent\Model;

trait CheckerTrait
{
    public function checkModelMustImplementInterface(Model $model)
    {
        if (!$model instanceof ModelElasticsearchInterface) {
            throw new Exception("The model must implement " . ModelElasticsearchInterface::class);
        }
    }
}
