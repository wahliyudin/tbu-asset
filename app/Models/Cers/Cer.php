<?php

namespace App\Models\Cers;

use App\Elasticsearch\Contracts\ElasticsearchInterface;
use App\Enums\Cers\Peruntukan;
use App\Enums\Cers\SumberPendanaan;
use App\Enums\Cers\TypeBudget;
use App\Enums\Workflows\Status;
use App\Models\Employee;
use App\Models\User;
use App\Services\Workflows\Contracts\ModelThatHaveWorkflow;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Cer extends Model implements ModelThatHaveWorkflow, ElasticsearchInterface
{
    use HasFactory;

    protected $fillable = [
        'no_cer',
        'nik',
        'type_budget',
        'department_id',
        'budget_ref',
        'peruntukan',
        'tgl_kebutuhan',
        'justifikasi',
        'sumber_pendanaan',
        'cost_analyst',
        'file_ucr',
        'status',
    ];

    protected $casts = [
        'type_budget' => TypeBudget::class,
        'sumber_pendanaan' => SumberPendanaan::class,
        'peruntukan' => Peruntukan::class,
        'status' => Status::class,
    ];

    public function indexName(): string
    {
        return 'tbu_asset_cers';
    }

    public function items(): HasMany
    {
        return $this->hasMany(CerItem::class);
    }

    public function workflow(): HasOne
    {
        return $this->hasOne(CerWorkflow::class)->latestOfMany();
    }

    public function workflows(): HasMany
    {
        return $this->hasMany(CerWorkflow::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'nik', 'nik');
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'nik', 'nik');
    }
}
