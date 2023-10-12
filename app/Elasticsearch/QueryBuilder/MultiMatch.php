<?php

namespace App\Elasticsearch\QueryBuilder;

use App\Elasticsearch\QueryBuilder\Contracts\Queryable;
use App\Elasticsearch\QueryBuilder\Traits\QueryTrait;

class MultiMatch implements Queryable
{
    use QueryTrait;

    protected $multiMatch = [];

    public function __construct($keyword, $fields = ['*'], $operator = 'and')
    {
        $this->multiMatch = [
            'query' => $keyword,
            'fields' => $fields,
            'operator' => $operator,
        ];
    }

    public function body()
    {
        return $this->multiMatch;
    }

    public function key()
    {
        return $this->name();
    }
}
