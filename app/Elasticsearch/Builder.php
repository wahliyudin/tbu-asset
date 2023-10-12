<?php

namespace App\Elasticsearch;

use App\Elasticsearch\BodyBuilder\Body;
use App\Elasticsearch\BodyBuilder\Document;
use App\Elasticsearch\BodyBuilder\Index;
use App\Elasticsearch\BodyBuilder\Settings;
use App\Elasticsearch\Build;
use App\Elasticsearch\QueryBuilder\MatchAll;
use App\Elasticsearch\QueryBuilder\MultiMatch;
use App\Elasticsearch\QueryBuilder\Must;
use App\Elasticsearch\QueryBuilder\Query;
use App\Elasticsearch\QueryBuilder\QueryBool;
use App\Elasticsearch\QueryBuilder\QueryMatch;
use App\Elasticsearch\QueryBuilder\QueryString;
use App\Elasticsearch\QueryBuilder\Range;
use App\Elasticsearch\QueryBuilder\Term;

trait Builder
{
    public function buildCreate($id, array $data)
    {
        $parent = new Build(
            new Index($this->index, $id, type: '_doc'),
            new Body(
                new Document($data)
            )
        );
        return $parent->build();
    }

    public function buildUpdated(array $data, $id)
    {
        $parent = new Build(
            new Index($this->index, $id, '_doc'),
            new Body(
                new Document($data, true)
            )
        );
        return $parent->build();
    }

    public function buildDeleted($id)
    {
        $parent = new Build(
            new Index($this->index, $id, '_doc')
        );
        return $parent->build();
    }

    public function buildCheckIndex()
    {
        $parent = new Build(
            new Index($this->index)
        );
        return $parent->build();
    }

    public function buildFind($id)
    {
        $parent = new Build(
            new Index($this->index, $id, '_doc')
        );
        return $parent->build();
    }

    public function buildCreateIndex(int $number_of_shards, int $number_of_replicas)
    {
        $parent = new Build(
            new Index($this->index),
            new Body(
                new Settings($number_of_shards, $number_of_replicas)
            )
        );
        return $parent->build();
    }

    public function buildCleared()
    {
        $parent = new Build(
            new Index($this->index),
            new Body(
                new Query(
                    new MatchAll()
                )
            )
        );
        return $parent->build();
    }

    public function buildSearchMultiMatch($keyword, $size)
    {
        $query = [];
        if ($keyword) {
            $query[] = new Query(
                new MultiMatch($keyword)
            );
        }
        $parent = new Build(
            new Index($this->index),
            (new Body(...$query))->size($size)
        );
        return $parent->build();
    }

    public function buildSearchQueryString($keyword, $size)
    {
        $query = [];
        if ($keyword) {
            $query[] = new QueryString($keyword);
        }
        $parent = new Build(
            new Index($this->index),
            (new Body(
                new Query(
                    ...$query
                )
            ))->size($size)
        );
        return $parent->build();
    }

    /**
     * @param string|null $keyword
     * @param array<QueryMatch> $matchs
     * @param array<Term> $terms
     * @param int $size
     *
     * @return array
     */
    public function buildSearchMultipleQuery(string $keyword = null, array $matchs = [], array $terms = [], int $size = 10)
    {
        $query = [];
        if ($keyword) {
            $query[] = new QueryString($keyword);
        }
        $parent = new Build(
            new Index($this->index),
            (new Body(
                new Query(
                    new QueryBool(
                        new Must(
                            ...$query,
                            ...$matchs,
                            ...$terms,
                        )
                    )
                )
            ))->size($size)
        );
        return $parent->build();
    }

    public function buildBulk(array $documents)
    {
        $childs = [];
        foreach ($documents as $key => $document) {
            $childs[] = new Index($this->index, $key, isMultiple: true);
            $childs[] = new Document($document);
        }
        $parent = new Body(
            ...$childs
        );
        return $parent->build();
    }

    public function buildSearchBetween(string $field, $gte, $lte, int $size)
    {
        $query = new Build(
            new Index($this->index),
            (new Body(
                new Query(
                    new Range($field, $gte, $lte)
                )
            ))->size($size)
        );
        return $query->build();
    }
}
