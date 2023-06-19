<?php

namespace App\Models;

use Database\Factories\Masters\UnitFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode',
        'model',
        'type',
        'seri',
        'class',
        'brand',
        'serial_number',
        'spesification',
        'tahun_pembuatan',
    ];

    protected static function newFactory(): Factory
    {
        return UnitFactory::new();
    }
}
