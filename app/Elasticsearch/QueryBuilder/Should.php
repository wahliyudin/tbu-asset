<?php

namespace App\Elasticsearch\QueryBuilder;

use App\Elasticsearch\QueryBuilder\Contracts\Shouldable;
use App\Elasticsearch\QueryBuilder\Contracts\Boolable;
use App\Elasticsearch\QueryBuilder\Traits\QueryTrait;

class Should extends QueryParent implements Boolable
{
    use QueryTrait;

    public function __construct(
        Shouldable ...$childs
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
