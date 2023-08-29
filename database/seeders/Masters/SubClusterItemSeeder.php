<?php

namespace Database\Seeders\Masters;

use App\DataTransferObjects\Masters\SubClusterItemData;
use App\Facades\Elasticsearch;
use App\Models\Masters\SubClusterItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubClusterItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Start Get data subClusterItems');
        $subClusterItems = SubClusterItem::query()->with(['subCluster.cluster.category'])->get();
        $this->command->info('End Get data subClusterItems');
        $this->command->info('Start Cleared subClusterItems');
        Elasticsearch::setModel(SubClusterItem::class)->cleared();
        $this->command->info('End Cleared subClusterItems');
        $this->command->info('Start Bulk subClusterItems');
        Elasticsearch::setModel(SubClusterItem::class)->bulk(SubClusterItemData::collection($subClusterItems));
        $this->command->info('End Bulk subClusterItems');
    }
}
