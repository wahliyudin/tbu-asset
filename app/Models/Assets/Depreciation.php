<?php

namespace App\Models\Assets;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Depreciation extends Model
{
    use HasFactory;

    protected $fillable = [
        'asset_id',
        'masa_pakai',
        'umur_asset',
        'umur_pakai',
        'depresiasi',
        'sisa',
    ];

    public function asset(): BelongsTo
    {
        return $this->belongsTo(Asset::class);
    }
}
