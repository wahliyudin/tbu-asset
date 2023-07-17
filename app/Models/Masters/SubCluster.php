<?php

namespace App\Models\Masters;

use App\Elasticsearch\Contracts\ElasticsearchInterface;
use Database\Factories\Masters\SubClusterFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SubCluster extends Model implements ElasticsearchInterface
{
    use HasFactory;

    protected $fillable = [
        'cluster_id',
        'name',
    ];

    public function indexName(): string
    {
        return 'tbu_asset_sub_clusters';
    }

    protected static function newFactory(): Factory
    {
        return SubClusterFactory::new();
    }

    public function cluster(): BelongsTo
    {
        return $this->belongsTo(Cluster::class);
    }

    public function subClusterItems(): HasMany
    {
        return $this->hasMany(SubClusterItem::class);
    }
}
