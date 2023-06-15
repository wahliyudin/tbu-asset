<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;

    protected $fillable = [
        'model',
        'type',
        'seri',
        'class',
        'brand',
        'serial_number',
        'spesification',
        'tahun_pembuatan',
        'brand',
    ];
}
