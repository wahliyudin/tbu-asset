<?php

namespace App\Elasticsearch\QueryBuilder;

use App\Elasticsearch\QueryBuilder\Contracts\Nestedable;
use App\Elasticsearch\QueryBuilder\Contracts\Queryable;
use App\Elasticsearch\QueryBuilder\Traits\QueryTrait;

class Query extends QueryParent implements Nestedable
{
    use QueryTrait;

    public function __construct(
        Queryable ...$childs
    ) {
        parent::__construct(...$childs);
    }

    public function build()
    {
        return [
            'query' => $this->childs
        ];
    }

    public function body()
    {
        return $this->childs;
    }

    public function key()
    {
        return $this->name();
    }
}
