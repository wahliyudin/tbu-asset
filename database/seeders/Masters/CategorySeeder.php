<?php

namespace Database\Seeders\Masters;

use App\DataTransferObjects\Masters\CategoryData;
use App\Facades\Elasticsearch;
use App\Models\Masters\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Start Get data categories');
        $categories = Category::query()->with(['clusters.subClusters.subClusterItems'])->get();
        $this->command->info('End Get data categories');
        $this->command->info('Start Cleared categories');
        Elasticsearch::setModel(Category::class)->cleared();
        $this->command->info('End Cleared categories');
        $this->command->info('Start Bulk categories');
        Elasticsearch::setModel(Category::class)->bulk(CategoryData::collection($categories));
        $this->command->info('End Bulk categories');
    }
}
