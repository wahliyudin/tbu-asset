<?php

namespace App\Models\Transfers;

use App\Elasticsearch\Contracts\ElasticsearchInterface;
use App\Enums\Workflows\LastAction;
use App\Models\Assets\Asset;
use App\Services\Workflows\Contracts\ModelThatHaveWorkflow;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class AssetTransfer extends Model implements ModelThatHaveWorkflow, ElasticsearchInterface
{
    use HasFactory;

    protected $fillable = [
        'no_transaksi',
        'nik',
        'asset_id',
        'old_pic',
        'old_location',
        'old_divisi',
        'old_department',
        'new_pic',
        'new_location',
        'new_divisi',
        'new_department',
        'request_transfer_date',
        'justifikasi',
        'remark',
        'note',
        'transfer_date',
        'status',
    ];

    public function indexName(): string
    {
        return 'tbu_asset_transfers';
    }

    public function currentApproval(): HasOne
    {
        return $this->hasOne(TransferWorkflow::class)->ofMany([
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
        return $this->hasOne(TransferWorkflow::class)->latestOfMany();
    }

    public function workflows(): HasMany
    {
        return $this->hasMany(TransferWorkflow::class);
    }
}
