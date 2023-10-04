<?php

namespace App\Elasticsearch\Traits\Params;

trait QueryBool
{
    private array $must = [];
    private array $queryBool = [];

    protected function getQueryBool(): array
    {
        $this->queryBool['must'] = $this->must;
        return $this->queryBool;
    }

    protected function match($key, $value)
    {
        array_push($this->must, [
            'match' => [
                $key => $value
            ]
        ]);
        return $this;
    }

    protected function term($key, $value)
    {
        array_push($this->must, [
            'term' => [
                $key => $value
            ]
        ]);
        return $this;
    }

    protected function multiMatchBool($keyword)
    {
        array_push($this->must, [
            'multi_match' => [
                'query' => $keyword,
                'fields' => ['*'], // Mencari di semua atribut
                'operator' => 'and'
            ]
        ]);
        return $this;
    }

    protected function queryStringBool($keyword)
    {
        array_push($this->must, [
            'query_string' => [
                'query' => $keyword
            ]
        ]);
        return $this;
    }
}
