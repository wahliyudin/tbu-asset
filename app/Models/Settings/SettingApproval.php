<?php

namespace App\Models\Settings;

use App\Enums\Settings\Approval;
use App\Enums\Workflows\Module;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SettingApproval extends Model
{
    use HasFactory;

    protected $fillable = [
        'module',
        'approval',
        'nik',
        'title',
    ];

    protected $casts = [
        'module' => Module::class,
        'approval' => Approval::class,
    ];
}
