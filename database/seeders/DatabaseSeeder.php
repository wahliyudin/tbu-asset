<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Asset;
use App\Models\Masters\Catalog;
use App\Models\Masters\Category;
use App\Models\Masters\Cluster;
use App\Models\Masters\Dealer;
use App\Models\Masters\Leasing;
use App\Models\SubCluster;
use App\Models\SubClusterItem;
use App\Models\Masters\Unit;
use App\Models\User;
use Database\Factories\Masters\CatalogFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::query()->create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make(1234567890),
        ]);
        Catalog::factory(10)->create();
        Category::factory(10)->create();
        Dealer::factory(10)->create();
        Leasing::factory(10)->create();
        Cluster::factory(10)->create();
        SubCluster::factory(10)->create();
        SubClusterItem::factory(10)->create();
        Unit::factory(10)->create();
        Asset::factory(10)->create();
    }
}
