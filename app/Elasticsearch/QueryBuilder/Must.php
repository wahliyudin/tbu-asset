<?php

namespace App\Elasticsearch\QueryBuilder;

use App\Elasticsearch\QueryBuilder\Contracts\Mustable;
use App\Elasticsearch\QueryBuilder\Contracts\Boolable;
use App\Elasticsearch\QueryBuilder\Traits\QueryTrait;

class Must extends QueryParent implements Boolable
{
    use QueryTrait;

    public function __construct(
        Mustable ...$childs
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
