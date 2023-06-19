<?php

namespace App\Models\Disposes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AssetDispose extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_dispose',
        'nik',
        'nilai_buku',
        'est_harga_pasar',
        'notes',
        'justifikasi',
        'remark',
    ];

    public function asset(): BelongsTo
    {
        return $this->belongsTo(Asset::class);
    }
}
