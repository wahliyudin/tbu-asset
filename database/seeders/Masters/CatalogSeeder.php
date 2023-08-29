<?php

namespace Database\Seeders\Masters;

use App\DataTransferObjects\Masters\CatalogData;
use App\Facades\Elasticsearch;
use App\Models\Masters\Catalog;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CatalogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Start Get data catalogs');
        $catalogs = Catalog::query()->get();
        $this->command->info('End Get data catalogs');
        $this->command->info('Start Cleared catalogs');
        Elasticsearch::setModel(Catalog::class)->cleared();
        $this->command->info('End Cleared catalogs');
        $this->command->info('Start Bulk catalogs');
        Elasticsearch::setModel(Catalog::class)->bulk(CatalogData::collection($catalogs));
        $this->command->info('End Bulk catalogs');
    }
}
