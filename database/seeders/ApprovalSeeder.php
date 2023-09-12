<?php

namespace Database\Seeders;

use App\Enums\Settings\Approval;
use App\Enums\Workflows\Module;
use App\Models\Settings\SettingApproval;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ApprovalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $appravols = [
            [
                'module' => Module::CER_HO,
                'approval' => Approval::DEPARTMENT_HEAD,
                'nik' => null,
                'title' => 'Approved',
            ],
            [
                'module' => Module::CER_HO,
                'approval' => Approval::DIRECTOR,
                'nik' => null,
                'title' => 'Approved',
            ],
            [
                'module' => Module::TRANSFER,
                'approval' => Approval::ATASAN_LANGSUNG,
                'nik' => null,
                'title' => 'Approved',
            ],
            [
                'module' => Module::TRANSFER,
                'approval' => Approval::DIRECTOR,
                'nik' => null,
                'title' => 'Approved',
            ],
            [
                'module' => Module::DISPOSE,
                'approval' => Approval::ATASAN_LANGSUNG,
                'nik' => null,
                'title' => 'Approved',
            ],
            [
                'module' => Module::DISPOSE,
                'approval' => Approval::DIRECTOR,
                'nik' => null,
                'title' => 'Approved',
            ],
        ];

        SettingApproval::query()->upsert($appravols, 'id');
    }
}
