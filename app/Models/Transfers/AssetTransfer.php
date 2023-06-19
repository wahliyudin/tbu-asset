<?php

namespace App\Models\Transfers;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AssetTransfer extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_transaksi',
        'nik',
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
        'transfer_date',
    ];

    public function asset(): BelongsTo
    {
        return $this->belongsTo(Asset::class);
    }
}