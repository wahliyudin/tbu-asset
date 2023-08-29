<?php

namespace Database\Seeders\Masters;

use App\DataTransferObjects\Masters\DealerData;
use App\Facades\Elasticsearch;
use App\Models\Masters\Dealer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DealerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Start Get data dealers');
        $dealers = Dealer::query()->get();
        $this->command->info('End Get data dealers');
        $this->command->info('Start Cleared dealers');
        Elasticsearch::setModel(Dealer::class)->cleared();
        $this->command->info('End Cleared dealers');
        $this->command->info('Start Bulk dealers');
        Elasticsearch::setModel(Dealer::class)->bulk(DealerData::collection($dealers));
        $this->command->info('End Bulk dealers');
    }
}
