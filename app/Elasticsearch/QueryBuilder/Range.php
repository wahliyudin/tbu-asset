<?php

namespace App\Elasticsearch\QueryBuilder;

use App\Elasticsearch\QueryBuilder\Contracts\Queryable;
use App\Elasticsearch\QueryBuilder\Traits\QueryTrait;

class Range implements Queryable
{
    use QueryTrait;

    protected $range = [];

    public function __construct($field, $gte, $lte)
    {
        $this->range[$field] = [
            'gte' => $gte,
            'lte' => $lte,
        ];
    }

    public function body()
    {
        return $this->range;
    }

    public function key()
    {
        return $this->name();
    }
}
