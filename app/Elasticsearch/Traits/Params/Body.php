<?php

namespace App\Elasticsearch\Traits\Params;

trait Body
{
    use Setting, Query, QueryBool;

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
        $this->prepareSettings();
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
        $query = [];
        if (count($this->getQuery()) > 0) {
            $query = array_merge($query, $this->getQuery());
        }
        if (count($this->getQueryBool()['must']) > 0) {
            $query = array_merge($query, ['bool' => $this->getQueryBool()]);
        }
        if (count($query) > 0) {
            $this->body = array_merge($this->body, [
                'query' => $query
            ]);
        }
    }

    private function prepareSettings()
    {
        if (count($this->getSettings()) > 0) {
            $this->body = array_merge($this->body, [
                'settings' => $this->getSettings()
            ]);
        }
    }
}
