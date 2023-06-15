<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CerItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'model',
        'est_umur',
        'qty',
        'price',
        'uom',
    ];

    public function cer(): BelongsTo
    {
        return $this->belongsTo(Cer::class);
    }
}
