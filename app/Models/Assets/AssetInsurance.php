<?php

namespace App\Models\Assets;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AssetInsurance extends Model
{
    use HasFactory;

    protected $fillable = [
        'asset_id',
        'jangka_waktu',
        'biaya',
        'legalitas',
        'tanggal_awal',
        'tanggal_akhir',
    ];

    public function asset(): BelongsTo
    {
        return $this->belongsTo(Asset::class);
    }
}
