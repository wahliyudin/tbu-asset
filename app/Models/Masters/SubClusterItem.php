<?php

namespace App\Models\Masters;

use App\Elasticsearch\Contracts\ElasticsearchInterface;
use Database\Factories\Masters\SubClusterItemFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SubClusterItem extends Model implements ElasticsearchInterface
{
    use HasFactory;

    protected $fillable = [
        'sub_cluster_id',
        'name',
    ];

    public function indexName(): string
    {
        return 'tbu_asset_sub_cluster_items';
    }

    protected static function newFactory(): Factory
    {
        return SubClusterItemFactory::new();
    }

    public function subCluster(): BelongsTo
    {
        return $this->belongsTo(SubCluster::class);
    }
}
