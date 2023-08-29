<?php

namespace App\Elasticsearch\Traits\Params;

trait Setting
{
    private array $settings = [];

    protected function numberOfShards(int $number)
    {
        $this->settings = array_merge($this->settings, [
            'number_of_shards' => $number
        ]);
        return $this;
    }

    protected function numberOfReplicas(int $number)
    {
        $this->settings = array_merge($this->settings, [
            'number_of_replicas' => $number
        ]);
        return $this;
    }

    protected function getSettings()
    {
        return $this->settings;
    }
}
