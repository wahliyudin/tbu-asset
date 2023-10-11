<?php

namespace App\Elasticsearch\Builder;

use App\Elasticsearch\Builder\Contracts\Filterable;
use App\Elasticsearch\Builder\Contracts\Queryable;
use App\Elasticsearch\Builder\Traits\QueryTrait;

class Filter extends QueryParent implements Queryable
{
    use QueryTrait;

    public function __construct(
        Filterable ...$childs
    ) {
        parent::__construct(...$childs);
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
