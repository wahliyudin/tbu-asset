<?php

namespace App\Elasticsearch\BodyBuilder;

use App\Elasticsearch\BodyBuilder\Contracts\Bodyable;
use App\Elasticsearch\Traits\ParentTrait;

class Settings implements Bodyable
{
    use ParentTrait;

    protected $setting = [];

    public function __construct(int $number_of_shards, int $number_of_replicas)
    {
        $this->setting = [
            'number_of_shards' => $number_of_shards,
            'number_of_replicas' => $number_of_replicas,
        ];
    }

    public function body()
    {
        return $this->setting;
    }

    public function key()
    {
        return $this->name();
    }
}
