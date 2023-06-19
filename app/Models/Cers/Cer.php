<?php

namespace App\Models\Cers;

use App\Enums\Cers\TypeBudget;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cer extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_cer',
        'nik',
        'type_budget',
        'budger_ref',
        'peruntukan',
        'tgl_kebutuhan',
        'justifikasi',
        'sumber_pendanaan',
        'cost_analyst',
    ];

    protected $casts = [
        'type_budget' => TypeBudget::class
    ];
}