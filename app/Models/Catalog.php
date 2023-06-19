<?php

namespace App\Models;

use Database\Factories\Masters\CatalogFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
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

    protected static function newFactory(): Factory
    {
        return CatalogFactory::new();
    }
}
