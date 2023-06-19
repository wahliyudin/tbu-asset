<?php

namespace App\Masters\Models;

use Database\Factories\Masters\ClusterFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cluster extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
    ];

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
