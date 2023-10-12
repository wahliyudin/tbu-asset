<?php

namespace App\Elasticsearch\QueryBuilder;

use App\Elasticsearch\QueryBuilder\Contracts\Queryable;
use App\Elasticsearch\QueryBuilder\Traits\QueryTrait;

class MatchAll implements Queryable
{
    use QueryTrait;
    public function body()
    {
        return (object)[];
    }

    public function key()
    {
        return $this->name();
    }
}
