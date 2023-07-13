<?php

namespace App\Elasticsearch;

class QueryBuilder
{
    private array $query = [];

    protected function getQuery(): array
    {
        return $this->query;
    }

    protected function matchAll(array $query = [])
    {
        $this->query = array_merge($this->query, [
            'match_all' => $query
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