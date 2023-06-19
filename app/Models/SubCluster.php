<?php

namespace App\Models;

use Database\Factories\Masters\SubClusterFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SubCluster extends Model
{
    use HasFactory;

    protected $fillable = [
        'cluster_id',
        'name',
    ];

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
