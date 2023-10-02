<?php

namespace App\Models\Disposes;

use App\Elasticsearch\Contracts\ElasticsearchInterface;
use App\Enums\Disposes\Dispose\Pelaksanaan;
use App\Enums\Workflows\LastAction;
use App\Enums\Workflows\Status;
use App\Models\Assets\Asset;
use App\Services\Workflows\Contracts\ModelThatHaveWorkflow;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class AssetDispose extends Model implements ModelThatHaveWorkflow, ElasticsearchInterface
{
    use HasFactory;

    protected $fillable = [
        'asset_id',
        'no_dispose',
        'nik',
        'nilai_buku',
        'est_harga_pasar',
        'notes',
        'justifikasi',
        'pelaksanaan',
        'remark',
        'note',
        'status',
    ];

    public function indexName(): string
    {
        return 'tbu_asset_transfers';
    }

    protected $casts = [
        'pelaksanaan' => Pelaksanaan::class,
        'status' => Status::class,
    ];

    public function currentApproval(): HasOne
    {
        return $this->hasOne(DisposeWorkflow::class)->ofMany([
            'sequence' => 'min',
        ], function ($query) {
            $query->where('last_action', LastAction::NOTTING);
        });
    }

    public function asset(): BelongsTo
    {
        return $this->belongsTo(Asset::class);
    }

    public function workflow(): HasOne
    {
        return $this->hasOne(DisposeWorkflow::class)->latestOfMany();
    }

    public function workflows(): HasMany
    {
        return $this->hasMany(DisposeWorkflow::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'nik', 'nik');
    }
}
