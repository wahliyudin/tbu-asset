<?php

namespace Database\Seeders\Masters;

use App\Models\Masters\Lifetime;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LifetimeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'masa_pakai' => 36,
            ],
            [
                'masa_pakai' => 48,
            ],
            [
                'masa_pakai' => 24,
            ],
        ];
        Lifetime::query()->upsert($data, 'id');
    }
}
