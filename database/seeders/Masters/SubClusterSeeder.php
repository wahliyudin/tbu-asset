<?php

namespace Database\Seeders\Masters;

use App\DataTransferObjects\Masters\SubClusterData;
use App\Facades\Elasticsearch;
use App\Models\Masters\SubCluster;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubClusterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Start Get data subClusters');
        $subClusters = SubCluster::query()->with(['cluster.category', 'subClusterItems'])->get();
        $this->command->info('End Get data subClusters');
        $this->command->info('Start Cleared subClusters');
        Elasticsearch::setModel(SubCluster::class)->cleared();
        $this->command->info('End Cleared subClusters');
        $this->command->info('Start Bulk subClusters');
        Elasticsearch::setModel(SubCluster::class)->bulk(SubClusterData::collection($subClusters));
        $this->command->info('End Bulk subClusters');
    }
}
