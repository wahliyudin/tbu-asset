<?php

namespace App\Models\Assets;

use App\Models\Masters\Dealer;
use App\Models\Masters\Leasing;
use App\Models\Masters\Lifetime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AssetLeasing extends Model
{
    use HasFactory;

    protected $fillable = [
        'asset_id',
        'dealer_id',
        'suplier_dealer',
        'leasing_id',
        'harga_beli',
        'jangka_waktu_leasing',
        'tanggal_awal_leasing',
        'tanggal_akhir_leasing',
        'lifetime_id',
        'biaya_leasing',
        'legalitas',
        'tanggal_perolehan'
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

    public function lifetime(): BelongsTo
    {
        return $this->belongsTo(Lifetime::class);
    }
}
