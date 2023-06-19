<?php

namespace App\Masters\Models;

use Database\Factories\Masters\CategoryFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    protected static function newFactory(): Factory
    {
        return CategoryFactory::new();
    }

    public function clusters(): HasMany
    {
        return $this->hasMany(Cluster::class);
    }
}
