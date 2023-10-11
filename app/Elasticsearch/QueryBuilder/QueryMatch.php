<?php

namespace App\Elasticsearch\QueryBuilder;

use App\Elasticsearch\QueryBuilder\Contracts\Matchable;
use App\Elasticsearch\QueryBuilder\Contracts\Mustable;
use App\Elasticsearch\QueryBuilder\Contracts\Queryable;
use App\Elasticsearch\QueryBuilder\Traits\QueryTrait;

class QueryMatch implements Queryable, Mustable
{
    use QueryTrait;

    protected array $match = [];

    public function __construct(
        string $field,
        string $value,
    ) {
        $this->match[$field] = $value;
    }

    public function body()
    {
        return $this->match;
    }

    public function key()
    {
        return $this->name('query');
    }
}
