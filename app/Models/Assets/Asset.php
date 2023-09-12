<?php

namespace App\Models\Assets;

use App\Elasticsearch\Contracts\ElasticsearchInterface;
use App\Enums\Asset\Status;
use App\Models\Assets\AssetInsurance;
use App\Models\Assets\AssetLeasing;
use App\Models\Assets\Depreciation;
use App\Models\Masters\SubCluster;
use App\Models\Masters\Unit;
use App\Models\Masters\Uom;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Asset extends Model implements ElasticsearchInterface
{
    use HasFactory;

    protected $fillable = [
        'kode',
        'new_id_asset',
        'unit_id',
        'sub_cluster_id',
        'pic',
        'activity',
        'asset_location',
        'kondisi',
        'uom_id',
        'quantity',
        'tgl_bast',
        'hm',
        'pr_number',
        'po_number',
        'gr_number',
        'remark',
        'qr_code',
        'status',
        'status_asset',
    ];

    protected $casts = [
        'status' => Status::class
    ];

    public function indexName(): string
    {
        return 'tbu_asset_assets';
    }

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

    public function depreciation(): HasOne
    {
        return $this->hasOne(Depreciation::class)->latestOfMany();
    }

    public function insurance()
    {
        return $this->hasOne(AssetInsurance::class);
    }

    public function leasing()
    {
        return $this->hasOne(AssetLeasing::class);
    }

    public function uom()
    {
        return $this->belongsTo(Uom::class);
    }
}
