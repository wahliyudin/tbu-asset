<?php

namespace App\Models\Disposes;

use App\Enums\Workflows\LastAction;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DisposeWorkflow extends Model
{
    use HasFactory;

    protected $fillable = [
        'sequence',
        'asset_dispose_id',
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

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'nik', 'nik');
    }
}
