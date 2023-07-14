<?php

namespace App\Elasticsearch;

use App\Elasticsearch\Traits\CheckerTrait;
use App\Interfaces\DataInterface;
use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Attributes\DataCollectionOf;

class Elasticsearch extends ParamBuilder
{
    use CheckerTrait;

    protected Client $clientBuilder;

    protected $data;

    protected Model $model;

    private string $type = '_doc';

    private object $response;

    private string $key;

    public function __construct()
    {
        $this->clientBuilder = ClientBuilder::create()
            ->setHosts(config('database.connections.elasticsearch.hosts'))
            ->setBasicAuthentication(config('database.connections.elasticsearch.username'), config('database.connections.elasticsearch.password'))
            ->build();
    }

    public function bulk(#[DataCollectionOf(DataInterface::class)] $data)
    {
        $params = [];
        foreach ($data as $record) {
            $elastic = $this->setData($record);
            $params['body'][] = [
                'index' => [
                    '_index' => $elastic->getIndex(),
                    '_id' => $elastic->getKey(),
                ]
            ];

            $params['body'][] = $record->toArray();
        }
        $this->clientBuilder->bulk($params);
        return $this;
    }

    public function find($id)
    {
        return $this->clientBuilder->get($this->setKey($id)->withId()->getParams());
    }

    public function created(DataInterface $data = null)
    {
        $this->setData($data);
        $this->clientBuilder->index($this->withId()->setAttributes($this->data->toArray())->getParams());
        return $this;
    }

    public function updated(DataInterface $data = null)
    {
        $this->setData($data);
        $this->clientBuilder->update($this->withId()->setDoc($this->data->toArray())->getParams());
        return $this;
    }

    public function deleted(DataInterface $data = null)
    {
        $this->setData($data);
        $this->clientBuilder->delete($this->withId()->getParams());
        return $this;
    }

    public function cleared()
    {
        $this->clientBuilder->deleteByQuery($this->withoutType()->matchAll()->getParams());
        return $this;
    }

    public function createIndex()
    {
        if ($this->clientBuilder->indices()->exists($this->withoutType()->getParams())->asBool()) {
            return;
        }
        $params = $this->numberOfShards(5)->numberOfReplicas(2)->withoutType()->getParams();
        $this->clientBuilder->indices()->create($params);
        return $this;
    }

    private function setData(DataInterface $data)
    {
        $this->data = $data;
        return $this;
    }

    public function searchQueryString($keyword = null, int $size = 10)
    {
        $params = $this->withoutType()->size($size)->getParams();
        if ($keyword) {
            $params = array_merge($params, $this->queryString($keyword)->getParams());
        }
        $this->response = $this->clientBuilder->search($params)->asObject();
        return $this;
    }

    public function all(): array
    {
        return $this->response?->hits?->hits ?? [];
    }

    public function getIndex(): string
    {
        return $this->model->indexName();
    }

    public function setModel($classModel)
    {
        $model = new $classModel;
        $this->checkModelMustImplementInterface($model);
        $this->model = $model;
        return $this;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getKey(): string|null
    {
        return $this->key ?? $this->data?->getKey();
    }

    public function setKey($key)
    {
        $this->key = $key;
        return $this;
    }
}