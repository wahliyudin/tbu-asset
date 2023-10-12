<?php

namespace App\Elasticsearch;

use App\Elasticsearch\BodyBuilder\Body;
use App\Elasticsearch\BodyBuilder\Document;
use App\Elasticsearch\BodyBuilder\Index;
use App\Elasticsearch\BodyBuilder\Size;
use App\Elasticsearch\Build;
use App\Elasticsearch\QueryBuilder\Query;
use App\Elasticsearch\QueryBuilder\QueryString;

class Implement
{
    public static function create(array $data)
    {
        $parent = new Build(
            new Index('tbu_asset_cetagories', type: '_doc'),
            new Body(
                new Document($data)
            )
        );
        return $parent->build();
    }

    public static function updated(array $data)
    {
        $parent = new Build(
            new Index('tbu_asset_cetagories', 1, '_doc'),
            new Body(
                new Document($data, true)
            )
        );
        return $parent->build();
    }

    public static function deleted($id)
    {
        $parent = new Build(
            new Index('tbu_asset_cetagories', $id, '_doc')
        );
        return $parent->build();
    }

    public static function bulk(array $documents)
    {
        $childs = [];
        foreach ($documents as $key => $document) {
            $childs[] = new Index('tbu_asset_cetagories', $key, isMultiple: true);
            $childs[] = new Document($document);
        }
        $parent = new Body(
            ...$childs
        );
        return $parent->build();
    }
}
