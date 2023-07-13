<?php

namespace App\Elasticsearch;

class BodyBuilder extends QueryBuilder
{
    private array $body = [];

    protected function setAttributes(array $attributes)
    {
        $this->body = array_merge($this->body, $attributes);
        return $this;
    }

    protected function setDoc(array $attributes)
    {
        $this->body = array_merge($this->body, [
            'doc' => $attributes
        ]);
        return $this;
    }

    protected function getBody(): array
    {
        $this->prepareQuery();
        return $this->body;
    }

    protected function size(int $size)
    {
        $this->body = array_merge($this->body, [
            'size' => $size
        ]);
        return $this;
    }

    private function prepareQuery()
    {
        if (count($this->getQuery()) > 0) {
            $this->body = array_merge($this->body, [
                'query' => $this->getQuery()
            ]);
        }
    }
}
