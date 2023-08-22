<?php

namespace App\Models\Masters;

use Database\Factories\Masters\UomFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Uom extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'keterangan',
    ];

    protected static function newFactory(): Factory
    {
        return UomFactory::new();
    }
}
