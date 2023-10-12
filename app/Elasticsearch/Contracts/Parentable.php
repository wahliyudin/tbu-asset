<?php

namespace App\Elasticsearch\Contracts;

interface Parentable
{
    public function name(string $remove = '');

    public function body();

    public function key();
}
