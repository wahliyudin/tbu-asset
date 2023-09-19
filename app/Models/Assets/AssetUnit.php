<?php

namespace App\Models\Assets;

use App\Models\Masters\Unit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetUnit extends Model
{
    use HasFactory;

    protected $fillable = [
        'unit_id',
        'kode',
        'type',
        'seri',
        'class',
        'brand',
        'serial_number',
        'spesification',
        'tahun_pembuatan',
        'kelengkapan_tambahan',
    ];

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}
