<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lifetime extends Model
{
    use HasFactory;

    protected $fillable = [
        'masa_pakai'
    ];
}
