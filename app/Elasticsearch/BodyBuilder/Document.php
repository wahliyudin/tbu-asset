<?php

namespace App\Elasticsearch\BodyBuilder;

use App\Elasticsearch\BodyBuilder\Contracts\Bodyable;
use App\Elasticsearch\Traits\ParentTrait;

class Document implements Bodyable
{
    use ParentTrait;

    protected $document = [];

    public function __construct(
        array $document,
        protected $withKey = false
    ) {
        $this->document = $document;
    }

    public function body()
    {
        return $this->document;
    }

    public function key()
    {
        return $this->withKey ? 'doc' : null;
    }
}
