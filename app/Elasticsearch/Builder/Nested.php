<?php

namespace App\Elasticsearch\Builder;

use App\Elasticsearch\Builder\Contracts\Nestedable;
use App\Elasticsearch\Builder\Contracts\Queryable;
use App\Elasticsearch\Builder\Traits\QueryTrait;

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
