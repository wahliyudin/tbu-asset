<?php

namespace App\Elasticsearch\Builder;

use App\Elasticsearch\Builder\Contracts\Shouldable;
use App\Elasticsearch\Builder\Contracts\Boolable;
use App\Elasticsearch\Builder\Traits\QueryTrait;

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
