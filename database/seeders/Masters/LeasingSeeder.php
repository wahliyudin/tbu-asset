<?php

namespace Database\Seeders\Masters;

use App\DataTransferObjects\Masters\LeasingData;
use App\Facades\Elasticsearch;
use App\Models\Masters\Leasing;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LeasingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Start Get data leasings');
        $leasings = Leasing::query()->get();
        $this->command->info('End Get data leasings');
        $this->command->info('Start Cleared leasings');
        Elasticsearch::setModel(Leasing::class)->cleared();
        $this->command->info('End Cleared leasings');
        $this->command->info('Start Bulk leasings');
        Elasticsearch::setModel(Leasing::class)->bulk(LeasingData::collection($leasings));
        $this->command->info('End Bulk leasings');
    }
}
