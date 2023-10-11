<?php

namespace App\Elasticsearch\Builder\Contracts;

interface Parentable
{
    public function name(string $remove = '');

    public function body();

    public function key();
}
