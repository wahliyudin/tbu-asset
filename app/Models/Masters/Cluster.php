<?php

namespace App\Models\Masters;

use App\Elasticsearch\Contracts\ElasticsearchInterface;
use Database\Factories\Masters\ClusterFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cluster extends Model implements ElasticsearchInterface
{
    use HasFactory;

    protected $fillable = [
        'id',
        'category_id',
        'name',
    ];

    public function indexName(): string
    {
        return 'tbu_asset_clusters';
    }

    protected static function newFactory(): Factory
    {
        return ClusterFactory::new();
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function subClusters(): HasMany
    {
        return $this->hasMany(SubCluster::class);
    }
}
