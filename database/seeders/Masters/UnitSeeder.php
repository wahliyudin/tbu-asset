<?php

namespace Database\Seeders\Masters;

use App\DataTransferObjects\Masters\UnitData;
use App\Facades\Elasticsearch;
use App\Models\Masters\Unit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Start Get data units');
        $units = Unit::query()->get();
        $this->command->info('End Get data units');
        $this->command->info('Start Cleared units');
        Elasticsearch::setModel(Unit::class)->cleared();
        $this->command->info('End Cleared units');
        $this->command->info('Start Bulk units');
        Elasticsearch::setModel(Unit::class)->bulk(UnitData::collection($units));
        $this->command->info('End Bulk units');
    }
}
