<?php

namespace App\Elasticsearch\QueryBuilder;

use App\Elasticsearch\QueryBuilder\Contracts\MustNotable;
use App\Elasticsearch\QueryBuilder\Contracts\Boolable;
use App\Elasticsearch\QueryBuilder\Traits\QueryTrait;

class MustNot extends QueryParent implements Boolable
{
    use QueryTrait;

    public function __construct(
        MustNotable ...$childs
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
