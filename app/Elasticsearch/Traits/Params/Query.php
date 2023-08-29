<?php

namespace App\Elasticsearch\Traits\Params;

trait Query
{
    private array $query = [];

    protected function getQuery(): array
    {
        return $this->query;
    }

    protected function matchAll(array $query = [])
    {
        $this->query = array_merge($this->query, [
            'match_all' => (object) $query
        ]);
        return $this;
    }

    protected function queryString($keyword)
    {
        $this->query = array_merge($this->query, [
            'query_string' => [
                'query' => $keyword
            ]
        ]);
        return $this;
    }
}
