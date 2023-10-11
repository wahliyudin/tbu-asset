<?php

namespace App\Elasticsearch\Builder;

use App\Elasticsearch\Builder\Contracts\Mustable;
use App\Elasticsearch\Builder\Contracts\Boolable;
use App\Elasticsearch\Builder\Traits\QueryTrait;

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
