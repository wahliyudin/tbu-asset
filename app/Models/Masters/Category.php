<?php

namespace App\Models\Masters;

use App\Elasticsearch\Contracts\ElasticsearchInterface;
use Database\Factories\Masters\CategoryFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model implements ElasticsearchInterface
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function indexName(): string
    {
        return 'tbu_asset_cetagories';
    }

    protected static function newFactory(): Factory
    {
        return CategoryFactory::new();
    }

    public function clusters(): HasMany
    {
        return $this->hasMany(Cluster::class);
    }
}
