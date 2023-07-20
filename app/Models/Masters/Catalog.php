<?php

namespace App\Models\Masters;

use App\Elasticsearch\Contracts\ElasticsearchInterface;
use Database\Factories\Masters\CatalogFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Catalog extends Model implements ElasticsearchInterface
{
    use HasFactory;

    protected $fillable = [
        'unit_model',
        'unit_type',
        'seri',
        'unit_class',
        'brand',
        'spesification',
    ];

    public function indexName(): string
    {
        return 'tbu_asset_catalogs';
    }

    protected static function newFactory(): Factory
    {
        return CatalogFactory::new();
    }
}
