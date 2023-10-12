<?php

namespace App\Elasticsearch\QueryBuilder;

use App\Elasticsearch\QueryBuilder\Contracts\Queryable;
use App\Elasticsearch\QueryBuilder\Traits\QueryTrait;

class QueryString implements Queryable
{
    use QueryTrait;

    protected $queryString = [];

    public function __construct($keyword)
    {
        $this->queryString['query'] = $keyword;
    }

    public function body()
    {
        return $this->queryString;
    }

    public function key()
    {
        return $this->name();
    }
}
