<?php

namespace App\Elasticsearch\Traits;

use App\Elasticsearch\Contracts\ElasticsearchInterface;
use Exception;
use Illuminate\Database\Eloquent\Model;

trait CheckerTrait
{
    public function checkModelMustImplementInterface(Model $model)
    {
        if (!$model instanceof ElasticsearchInterface) {
            throw new Exception("The model must implement " . ElasticsearchInterface::class);
        }
    }
}