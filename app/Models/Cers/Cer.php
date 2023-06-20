<?php

namespace App\Models\Cers;

use App\Enums\Cers\TypeBudget;
use App\Interfaces\ModelWithWorkflowInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Cer extends Model implements ModelWithWorkflowInterface
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

    public function workflow(): HasOne
    {
        return $this->hasOne(CerWorkflow::class)->latestOfMany();
    }

    public function workflows(): HasMany
    {
        return $this->hasMany(CerWorkflow::class);
    }
}
