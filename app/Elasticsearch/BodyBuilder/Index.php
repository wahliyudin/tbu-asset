<?php

namespace App\Elasticsearch\BodyBuilder;

use App\Elasticsearch\BodyBuilder\Contracts\Bodyable;
use App\Elasticsearch\Contracts\Globalable;
use App\Elasticsearch\Traits\ParentTrait;

class Index implements Bodyable, Globalable
{
    use ParentTrait;

    protected $index = [];

    public function __construct($index, $id = null, $type = null, protected $isMultiple = false)
    {
        $this->index = $this->init($index, $id, $type);
    }

    public function init($index, $id = null, $type = null)
    {
        if ($this->isMultiple) {
            return [
                '_index' => $index,
                '_id' => $id,
            ];
        }
        $arr = [
            'index' => $index,
        ];
        if ($id) {
            $arr['id'] = $id;
        }
        if ($type) {
            $arr['type'] = $type;
        }
        return $arr;
    }

    public function body()
    {
        return $this->index;
    }

    public function key()
    {
        return $this->isMultiple ? $this->name() : null;
    }
}
