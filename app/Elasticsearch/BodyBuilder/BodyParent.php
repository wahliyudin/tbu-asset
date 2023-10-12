<?php

namespace App\Elasticsearch\BodyBuilder;

use App\Elasticsearch\Contracts\Parentable;

class BodyParent
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
            if ($child->key()) {
                if (count($childs) <= 1) {
                    $this->childs[$child->key()] = $child->body();
                    break;
                }
                $this->childs[][$child->key()] = $child->body();
            } else {
                $this->childs[] = $child->body();
            }
        }
    }
}
