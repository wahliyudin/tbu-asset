<?php

namespace App\Models\Cers;

use App\Enums\Workflows\LastAction;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CerWorkflow extends Model
{
    use HasFactory;

    protected $fillable = [
        'sequence',
        'cer_id',
        'nik',
        'title',
        'last_action',
        'last_action_date',
    ];

    protected $casts = [
        'last_action' => LastAction::class
    ];

    public function cer(): BelongsTo
    {
        return $this->belongsTo(Cer::class);
    }
}
