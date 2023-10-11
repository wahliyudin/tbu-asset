<?php

namespace App\Elasticsearch\QueryBuilder;

use App\Elasticsearch\QueryBuilder\Contracts\Shouldable;
use App\Elasticsearch\QueryBuilder\Traits\QueryTrait;

class Wildcard implements Shouldable
{
    use QueryTrait;

    protected $wildcard = [];

    public function __construct($field, $value)
    {
        $this->wildcard[$field] = $value;
    }

    public function body()
    {
        return $this->wildcard;
    }

    public function key()
    {
        return $this->name();
    }
}
