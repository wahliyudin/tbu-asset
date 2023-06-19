<?php

namespace App\Models\Masters;

use Database\Factories\Masters\LeasingFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leasing extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    protected static function newFactory(): Factory
    {
        return LeasingFactory::new();
    }
}
