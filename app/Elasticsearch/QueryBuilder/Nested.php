<?php

namespace App\Elasticsearch\QueryBuilder;

use App\Elasticsearch\QueryBuilder\Contracts\Nestedable;
use App\Elasticsearch\QueryBuilder\Contracts\Queryable;
use App\Elasticsearch\QueryBuilder\Traits\QueryTrait;

class Nested extends QueryParent implements Queryable
{
    use QueryTrait;

    public function __construct(
        string $path,
        Nestedable ...$childs
    ) {
        $this->childs['path'] = $path;
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
