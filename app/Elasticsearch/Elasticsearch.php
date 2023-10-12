<?php

namespace App\Elasticsearch;

use App\Elasticsearch\Traits\CheckerTrait;
use App\Interfaces\DataInterface;
use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
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

    public function __construct(
        protected Builder $builder
    ) {
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
        if (count(isset($params['body']) ? $params['body'] : []) <= 0) {
            return;
        }
        $this->clientBuilder->bulk($params);
    }

    public function find($id)
    {
        return $this->clientBuilder->get($this->builder->buildFind($this->getIndex(), $id));
    }

    public function created(DataInterface $data = null)
    {
        try {
            $this->clientBuilder->index($this->builder->buildCreate($this->getIndex(), $data->getKey(), $data->toArray()));
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage(), in_array($th->getCode(), [500, 404, 422]) ? $th->getCode() : 500);
        }
        return $this;
    }

    public function updated(DataInterface $data = null)
    {
        try {
            $this->clientBuilder->update($this->builder->buildUpdated($this->getIndex(), $data->toArray(), $data->getKey()));
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage(), in_array($th->getCode(), [500, 404, 422]) ? $th->getCode() : 500);
        }
        return $this;
    }

    public function deleted(DataInterface $data = null)
    {
        try {
            $this->clientBuilder->delete($this->builder->buildDeleted($this->getIndex(), $data->getKey()));
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage(), in_array($th->getCode(), [500, 404, 422]) ? $th->getCode() : 500);
        }
        return $this;
    }

    public function cleared()
    {
        return DB::transaction(function () {
            $this->clientBuilder->deleteByQuery($this->builder->buildCleared($this->getIndex(),));
            $this->model->delete();
            return $this;
        });
    }

    public function createIndex()
    {
        if ($this->clientBuilder->indices()->exists($this->builder->buildCheckIndex($this->getIndex(),))->asBool()) {
            return;
        }
        $params = $this->builder->buildCreateIndex($this->getIndex(), 5, 2);
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
        $this->response = $this->clientBuilder->search($this->builder->buildSearchQueryString($this->getIndex(), $keyword, $size))->asObject();
        return $this;
    }

    public function searchMultiMatch($keyword = null, int $size = 10)
    {
        $this->response = $this->clientBuilder->search($this->builder->buildSearchMultiMatch($this->getIndex(), $keyword, $size))->asObject();
        return $this;
    }

    public function searchMultipleQuery($keyword = null, array $matchs = [], array $terms = [], int $size = 10)
    {
        $this->response = $this->clientBuilder->search($this->builder->buildSearchMultipleQuery($this->getIndex(), $keyword, $matchs, $terms, $size))->asObject();
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
