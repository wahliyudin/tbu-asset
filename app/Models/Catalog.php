<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Catalog extends Model
{
    use HasFactory;

    protected $fillable = [
        'unit_model',
        'unit_type',
        'seri',
        'unit_class',
        'brand',
        'spesification',
    ];
}
