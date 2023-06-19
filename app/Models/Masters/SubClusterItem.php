<?php

namespace App\Models\Masters;

use Database\Factories\Masters\SubClusterItemFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SubClusterItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'sub_cluster_id',
        'name',
    ];

    protected static function newFactory(): Factory
    {
        return SubClusterItemFactory::new();
    }

    public function subCluster(): BelongsTo
    {
        return $this->belongsTo(SubCluster::class);
    }
}
