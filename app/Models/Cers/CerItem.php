<?php

namespace App\Models\Cers;

use App\Models\Masters\Uom;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CerItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'cer_id',
        'description',
        'model',
        'est_umur',
        'qty',
        'price',
        'uom_id',
        'is_register',
    ];

    public function cer(): BelongsTo
    {
        return $this->belongsTo(Cer::class);
    }

    public function uom(): BelongsTo
    {
        return $this->belongsTo(Uom::class);
    }
}
