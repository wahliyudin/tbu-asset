<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\DataTransferObjects\Assets\AssetData;
use App\Facades\Elasticsearch;
use App\Models\Assets\Asset;
use App\Models\Assets\AssetInsurance;
use App\Models\Assets\AssetLeasing;
use App\Models\Masters\Catalog;
use App\Models\Masters\Category;
use App\Models\Masters\Cluster;
use App\Models\Masters\Dealer;
use App\Models\Masters\Leasing;
use App\Models\Masters\SubCluster;
use App\Models\Masters\SubClusterItem;
use App\Models\Masters\Unit;
use App\Models\Permission;
use App\Models\User;
use Database\Seeders\Masters\UomSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            SidebarWithPermissionSeeder::class,
            UomSeeder::class,
            ApprovalSeeder::class,
        ]);
        Catalog::factory(10)->create();
        Dealer::factory(10)->create();
        Leasing::factory(10)->create();
        Category::factory(2)->create();
        Cluster::factory(10)->create();
        SubCluster::factory(10)->create();
        SubClusterItem::factory(10)->create();
        Unit::factory(10)->create();
        Asset::factory(300)->create();
        AssetLeasing::factory(10)->create();
        AssetInsurance::factory(10)->create();

        $user = User::query()->create([
            'nik' => 12345678,
            'name' => 'Administrator',
            'email' => 'administrator@tbu.co.id',
            'password' => Hash::make(1234567890),
        ]);
        $user->permissions()->sync(Permission::query()->pluck('id')->toArray());

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
