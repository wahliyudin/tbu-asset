<?php

namespace Database\Seeders\Assets;

use App\DataTransferObjects\Assets\AssetData;
use App\Facades\Elasticsearch;
use App\Models\Assets\Asset;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AssetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Start Get data asset');
        $assets = Asset::query()->with(['unit', 'subCluster', 'depreciations', 'depreciation', 'insurance', 'leasing'])->get();
        $this->command->info('End Get data asset');
        $this->command->info('Start Cleared assets');
        Elasticsearch::setModel(Asset::class)->cleared();
        $this->command->info('End Cleared assets');
        $this->command->info('Start Bulk assets');
        Elasticsearch::setModel(Asset::class)->bulk(AssetData::collection($assets));
        $this->command->info('End Bulk assets');
    }
}
