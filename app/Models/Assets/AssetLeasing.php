<?php

namespace App\Models\Assets;

use App\Models\Masters\Dealer;
use App\Models\Masters\Leasing;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AssetLeasing extends Model
{
    use HasFactory;

    protected $fillable = [
        'asset_id',
        'dealer_id',
        'leasing_id',
        'harga_beli',
        'jangka_waktu_leasing',
        'biaya_leasing',
        'legalitas',
    ];

    public function asset(): BelongsTo
    {
        return $this->belongsTo(Asset::class);
    }

    public function dealer(): BelongsTo
    {
        return $this->belongsTo(Dealer::class);
    }

    public function leasing(): BelongsTo
    {
        return $this->belongsTo(Leasing::class);
    }
}
