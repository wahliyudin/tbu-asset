<?php

namespace App\Elasticsearch;

use App\Elasticsearch\Traits\Params\Body;
use Illuminate\Support\Arr;

abstract class ParamBuilder
{
    use Body;

    private array $params = [];

    private array $withouts = [];

    protected function withId()
    {
        $this->params = array_merge($this->params, [
            'id' => $this->getKey()
        ]);
        return $this;
    }

    protected function getParams(): array
    {
        $this->defaultParams();
        $this->params = $this->prepareBody();
        $this->params = $this->prepareWithouts();
        return $this->params;
    }

    protected function withoutType()
    {
        $this->withouts = array_merge($this->withouts, ['type']);
        return $this;
    }

    private function prepareWithouts()
    {
        return Arr::except($this->params, $this->withouts);
    }

    private function prepareBody()
    {
        if (count($this->getBody()) <= 0) {
            return $this->params;
        }
        return array_merge($this->params, [
            'body' => $this->getBody()
        ]);
    }

    private function defaultParams()
    {
        $this->params = array_merge($this->params, [
            'index' => $this->getIndex(),
            'type' => $this->getType(),
        ]);
    }

    public abstract function getIndex(): string;

    public abstract function getType(): string;

    public abstract function getKey(): string|null;
}
