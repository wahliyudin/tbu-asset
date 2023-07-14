<?php

namespace App\Elasticsearch\Contracts;

interface ElasticsearchInterface
{
    public function indexName(): string;
}
