<?php

namespace App\Elasticsearch\Builder;

use App\Elasticsearch\Builder\Contracts\Matchable;
use App\Elasticsearch\Builder\Contracts\Mustable;
use App\Elasticsearch\Builder\Contracts\Queryable;
use App\Elasticsearch\Builder\Traits\QueryTrait;

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
