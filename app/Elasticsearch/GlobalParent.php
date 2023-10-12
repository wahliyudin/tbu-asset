<?php

namespace App\Elasticsearch;

use App\Elasticsearch\Contracts\Globalable;
use Illuminate\Support\Arr;

class GlobalParent
{
    protected array $childs = [];

    public function __construct(
        Globalable ...$childs
    ) {
        $this->buildChilds(...$childs);
    }

    private function buildChilds(Globalable ...$childs)
    {
        foreach ($childs as $child) {
            $this->check($child);
        }
    }

    private function check(Globalable $child)
    {
        if ($this->exist($child)) {
            return $this->push($child);
        }
        return $this->merge($child);
    }

    private function exist(Globalable $child)
    {
        return in_array($child->key(), array_keys($this->childs));
    }

    private function checkKey(Globalable $child)
    {
        return !is_null($child->key());
    }

    private function push(Globalable $child)
    {
        if ($this->checkKey($child)) {
            return $this->childs[][$child->key()] = $child->body();
        }

        return $this->childs[] = $child->body();
    }

    private function merge(Globalable $child)
    {
        if ($this->checkKey($child)) {
            return $this->childs[$child->key()] = $child->body();
        }
        return $this->childs = $child->body();
    }
}
