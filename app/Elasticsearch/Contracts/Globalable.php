<?php

namespace App\Elasticsearch\Contracts;

interface Globalable
{
    public function name(string $remove = '');

    public function body();

    public function key();
}
