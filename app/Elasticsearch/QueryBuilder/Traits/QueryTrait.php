<?php

namespace App\Elasticsearch\QueryBuilder\Traits;

trait QueryTrait
{
    public function name(string $remove = '')
    {
        $remove = str($remove)->ucfirst()->value();
        return str(class_basename($this))
            ->replace($remove, '')
            ->snake()
            ->value();
    }
}
