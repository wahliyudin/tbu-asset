<?php

namespace App\Elasticsearch;

use App\Elasticsearch\Contracts\Globalable;
use App\Elasticsearch\QueryBuilder\Traits\QueryTrait;

class Build extends GlobalParent
{
    use QueryTrait;

    public function __construct(
        Globalable ...$childs
    ) {
        parent::__construct(...$childs);
    }

    public function build()
    {
        return $this->childs;
    }

    public function body()
    {
        return $this->childs;
    }

    public function key()
    {
        return null;
    }
}
