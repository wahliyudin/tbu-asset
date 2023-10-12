<?php

namespace App\Elasticsearch\BodyBuilder;

use App\Elasticsearch\BodyBuilder\Contracts\Bodyable;
use App\Elasticsearch\Contracts\Buildable;
use App\Elasticsearch\Contracts\Globalable;
use App\Elasticsearch\GlobalParent;
use App\Elasticsearch\Traits\ParentTrait;

class Body extends GlobalParent implements Buildable, Globalable
{
    use ParentTrait;

    public function __construct(
        Bodyable ...$childs
    ) {
        parent::__construct(...$childs);
    }

    public function build()
    {
        return [
            'body' => $this->childs
        ];
    }

    public function size($size)
    {
        $this->childs['size'] = $size;
        return $this;
    }

    public function body()
    {
        return $this->childs;
    }

    public function key()
    {
        return $this->name();
    }
}
