<?php

namespace App\Elasticsearch\Builder;

use App\Elasticsearch\Builder\Contracts\Shouldable;
use App\Elasticsearch\Builder\Traits\QueryTrait;

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
