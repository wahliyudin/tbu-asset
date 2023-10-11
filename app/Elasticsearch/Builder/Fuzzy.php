<?php

namespace App\Elasticsearch\Builder;

use App\Elasticsearch\Builder\Contracts\Shouldable;
use App\Elasticsearch\Builder\Traits\QueryTrait;

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
