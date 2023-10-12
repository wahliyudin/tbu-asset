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
use App\Elasticsearch\QueryBuilder\Term;

class Builder
{
    public function buildCreate(string $index, $id, array $data)
    {
        $parent = new Build(
            new Index($index, $id, type: '_doc'),
            new Body(
                new Document($data)
            )
        );
        return $parent->build();
    }

    public function buildUpdated(string $index, array $data, $id)
    {
        $parent = new Build(
            new Index($index, $id, '_doc'),
            new Body(
                new Document($data, true)
            )
        );
        return $parent->build();
    }

    public function buildDeleted(string $index, $id)
    {
        $parent = new Build(
            new Index($index, $id, '_doc')
        );
        return $parent->build();
    }

    public function buildCheckIndex(string $index,)
    {
        $parent = new Build(
            new Index($index)
        );
        return $parent->build();
    }

    public function buildFind(string $index, $id)
    {
        $parent = new Build(
            new Index($index, $id, '_doc')
        );
        return $parent->build();
    }

    public function buildCreateIndex(string $index, int $number_of_shards, int $number_of_replicas)
    {
        $parent = new Build(
            new Index($index),
            new Body(
                new Settings($number_of_shards, $number_of_replicas)
            )
        );
        return $parent->build();
    }

    public function buildCleared(string $index,)
    {
        $parent = new Build(
            new Index($index),
            new Body(
                new Query(
                    new MatchAll()
                )
            )
        );
        return $parent->build();
    }

    public function buildSearchMultiMatch(string $index, $keyword, $size)
    {
        $query = [];
        if ($keyword) {
            $query[] = new Query(
                new MultiMatch($keyword)
            );
        }
        $parent = new Build(
            new Index($index),
            (new Body(...$query))->size($size)
        );
        return $parent->build();
    }

    public function buildSearchQueryString(string $index, $keyword, $size)
    {
        $query = [];
        if ($keyword) {
            $query[] = new QueryString($keyword);
        }
        $parent = new Build(
            new Index($index),
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
    public function buildSearchMultipleQuery(string $index, string $keyword = null, array $matchs = [], array $terms = [], int $size = 10)
    {
        $query = [];
        if ($keyword) {
            $query[] = new QueryString($keyword);
        }
        $parent = new Build(
            new Index($index),
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

    public function buildBulk(string $index, array $documents)
    {
        $childs = [];
        foreach ($documents as $key => $document) {
            $childs[] = new Index($index, $key, isMultiple: true);
            $childs[] = new Document($document);
        }
        $parent = new Body(
            ...$childs
        );
        return $parent->build();
    }
}
