<?php

namespace App\Elasticsearch\QueryBuilder\Contracts;

interface Parentable
{
    public function name(string $remove = '');

    public function body();

    public function key();
}
