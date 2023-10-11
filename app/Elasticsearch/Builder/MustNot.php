<?php

namespace App\Elasticsearch\Builder;

use App\Elasticsearch\Builder\Contracts\MustNotable;
use App\Elasticsearch\Builder\Contracts\Boolable;
use App\Elasticsearch\Builder\Traits\QueryTrait;

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
