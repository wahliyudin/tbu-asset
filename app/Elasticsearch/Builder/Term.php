<?php

namespace App\Elasticsearch\Builder;

use App\Elasticsearch\Builder\Contracts\MustNotable;
use App\Elasticsearch\Builder\Traits\QueryTrait;

class Term implements MustNotable
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
