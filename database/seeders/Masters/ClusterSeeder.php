<?php

namespace Database\Seeders\Masters;

use App\DataTransferObjects\Masters\ClusterData;
use App\Facades\Elasticsearch;
use App\Models\Masters\Cluster;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClusterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Start Get data clusters');
        $clusters = Cluster::query()->with(['subClusters.subClusterItems', 'category'])->get();
        $this->command->info('End Get data clusters');
        $this->command->info('Start Cleared clusters');
        Elasticsearch::setModel(Cluster::class)->cleared();
        $this->command->info('End Cleared clusters');
        $this->command->info('Start Bulk clusters');
        Elasticsearch::setModel(Cluster::class)->bulk(ClusterData::collection($clusters));
        $this->command->info('End Bulk clusters');
    }
}
