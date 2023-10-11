<?php

namespace App\Elasticsearch\QueryBuilder;

use App\Elasticsearch\QueryBuilder\Contracts\Shouldable;
use App\Elasticsearch\QueryBuilder\Traits\QueryTrait;

class Fuzzy implements Shouldable
{
    use QueryTrait;

    protected $fuzzy = [];

    public function __construct($field, $value, $fuzziness = "1")
    {
        $this->fuzzy[$field] = [
            'value' => $value,
            'fuzziness' => $fuzziness,
        ];
    }

    public function body()
    {
        return $this->fuzzy;
    }

    public function key()
    {
        return $this->name();
    }
}
