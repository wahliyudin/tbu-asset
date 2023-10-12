<?php

namespace App\Elasticsearch\QueryBuilder;

use App\Elasticsearch\QueryBuilder\Contracts\Mustable;
use App\Elasticsearch\QueryBuilder\Contracts\MustNotable;
use App\Elasticsearch\QueryBuilder\Traits\QueryTrait;

class Term implements MustNotable, Mustable
{
    use QueryTrait;

    protected $term = [];

    public function __construct($field, $value)
    {
        $this->term[$field] = $value;
    }

    public function body()
    {
        return $this->term;
    }

    public function key()
    {
        return $this->name();
    }
}
