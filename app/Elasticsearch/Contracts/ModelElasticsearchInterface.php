<?php

namespace App\Elasticsearch\Contracts;

interface ModelElasticsearchInterface
{
    public function indexName(): string;
}
