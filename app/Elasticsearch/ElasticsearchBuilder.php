<?php

namespace App\Elasticsearch;

use App\Elasticsearch\Contracts\ModelElasticsearchInterface;
use App\Elasticsearch\Traits\CheckerTrait;
use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;
use Exception;
use Illuminate\Database\Eloquent\Model;

class ElasticsearchBuilder extends ParamBuilder
{
    use CheckerTrait;

    protected Client $clientBuilder;

    private Model $model;

    private string $type = '_doc';

    public function __construct()
    {
        $this->clientBuilder = ClientBuilder::create()
            ->setHosts(config('database.connections.elasticsearch.hosts'))
            ->build();
    }

    public function setModel(Model $model)
    {
        $this->checkModelMustImplementInterface($model);
        $this->model = $model;
        return $this;
    }

    public function setType(string $type)
    {
        $this->type = $type;
        return $this;
    }

    public function getIndex(): string
    {
        return $this->model->indexName();
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getKey(): string|null
    {
        return $this->model->getKey();
    }

    public function created()
    {
        $params = $this->withId()->setAttributes($this->model->getAttributes())->getParams();
        $this->clientBuilder->index($params);
    }

    public function updated()
    {
        $params = $this->withId()->setDoc($this->model->getAttributes())->getParams();
        $this->clientBuilder->update($params);
    }

    public function deleted()
    {
        $params = $this->withId()->getParams();
        $this->clientBuilder->delete($params);
    }

    public function cleared()
    {
        $params = $this->withoutType()->matchAll()->getParams();
        $this->clientBuilder->deleteByQuery($params);
    }

    public function searchQueryString($keyword = null, int $size = 10)
    {
        $params = $this->withoutType()->getParams();
        if ($keyword) {;
            $params = array_merge($params, $this->size($size)->queryString($keyword)->getParams());
        }
        $response = $this->clientBuilder->search($params);
        return $response['hits']['hits'];
    }
}
