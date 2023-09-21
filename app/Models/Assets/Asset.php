<?php

namespace App\Models\Assets;

use App\Elasticsearch\Contracts\ElasticsearchInterface;
use App\Enums\Asset\Status;
use App\Models\Assets\AssetInsurance;
use App\Models\Assets\AssetLeasing;
use App\Models\Assets\Depreciation;
use App\Models\Department;
use App\Models\Masters\SubCluster;
use App\Models\Masters\Uom;
use App\Models\Project;
use App\Models\Assets\AssetUnit;
use App\Models\Masters\Activity;
use App\Models\Masters\Condition;
use App\Models\Masters\Lifetime;
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
        'asset_unit_id',
        'sub_cluster_id',
        'pic',
        'activity_id',
        'asset_location',
        'dept_id',
        'condition_id',
        'uom_id',
        'quantity',
        'nilai_sisa',
        'tgl_bast',
        'hm',
        'pr_number',
        'po_number',
        'gr_number',
        'remark',
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

    public function assetUnit(): BelongsTo
    {
        return $this->belongsTo(AssetUnit::class);
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

    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }

    public function condition()
    {
        return $this->belongsTo(Condition::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'asset_location', 'project_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'dept_id', 'dept_id');
    }
}
