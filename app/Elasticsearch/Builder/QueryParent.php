<?php

namespace App\Elasticsearch\Builder;

use App\Elasticsearch\Builder\Contracts\Parentable;

class QueryParent
{
    protected array $childs = [];

    public function __construct(
        Parentable ...$childs
    ) {
        $this->buildChilds(...$childs);
    }

    private function buildChilds(Parentable ...$childs)
    {
        foreach ($childs as $child) {
            if (count($childs) <= 1) {
                $this->childs[$child->key()] = $child->body();
                break;
            }
            $this->childs[][$child->key()] = $child->body();
        }
    }
}
