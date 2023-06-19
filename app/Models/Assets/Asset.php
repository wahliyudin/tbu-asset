<?php

namespace App\Models\Assets;

use App\Enums\Asset\Status;
use App\Models\Assets\Assets\Depreciation;
use App\Models\Masters\SubCluster;
use App\Models\Masters\Unit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Asset extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode',
        'unit_id',
        'sub_cluster_id',
        'member_name',
        'pic',
        'activity',
        'asset_location',
        'kondisi',
        'uom',
        'quantity',
        'tgl_bast',
        'hm',
        'pr_number',
        'po_number',
        'gr_number',
        'remark',
        'status',
    ];

    protected $casts = [
        'status' => Status::class
    ];

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }

    public function subCluster(): BelongsTo
    {
        return $this->belongsTo(SubCluster::class);
    }

    public function depreciations(): HasMany
    {
        return $this->hasMany(Depreciation::class);
    }
}
