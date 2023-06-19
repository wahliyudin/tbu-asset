<?php

namespace App\Models\Disposes;

use App\Enums\Workflows\LastAction;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DisposeWorkflow extends Model
{
    use HasFactory;

    protected $fillable = [
        'sequence',
        'nik',
        'title',
        'last_action',
        'last_action_date',
    ];

    protected $casts = [
        'last_action' => LastAction::class
    ];

    public function assetDispose(): BelongsTo
    {
        return $this->belongsTo(AssetDispose::class);
    }
}
