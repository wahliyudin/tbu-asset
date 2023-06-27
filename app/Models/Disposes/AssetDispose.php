<?php

namespace App\Models\Disposes;

use App\Enums\Disposes\Dispose\Pelaksanaan;
use App\Enums\Disposes\Dispose\Status;
use App\Interfaces\ModelWithWorkflowInterface;
use App\Models\Assets\Asset;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class AssetDispose extends Model implements ModelWithWorkflowInterface
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
        'status',
    ];

    protected $casts = [
        'pelaksanaan' => Pelaksanaan::class,
        'status' => Status::class,
    ];

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
