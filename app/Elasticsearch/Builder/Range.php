<?php

namespace App\Elasticsearch\Builder;

use App\Elasticsearch\Builder\Contracts\Queryable;
use App\Elasticsearch\Builder\Traits\QueryTrait;

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
