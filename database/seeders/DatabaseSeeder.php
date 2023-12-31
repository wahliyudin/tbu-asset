<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\DataTransferObjects\Assets\AssetData;
use App\Facades\Elasticsearch;
use App\Models\Assets\Asset;
use App\Models\Assets\AssetInsurance;
use App\Models\Assets\AssetLeasing;
use App\Models\Cers\Cer;
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
use Database\Seeders\Assets\AssetSeeder;
use Database\Seeders\Masters\CatalogSeeder;
use Database\Seeders\Masters\CategorySeeder;
use Database\Seeders\Masters\ClusterSeeder;
use Database\Seeders\Masters\DealerSeeder;
use Database\Seeders\Masters\LeasingSeeder;
use Database\Seeders\Masters\LifetimeSeeder;
use Database\Seeders\Masters\SubClusterItemSeeder;
use Database\Seeders\Masters\SubClusterSeeder;
use Database\Seeders\Masters\UnitSeeder;
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
        // User::query()->create([
        //     'nik' => 12345678,
        //     'name' => 'Administrator',
        //     'email' => 'administrator@.co.id',
        //     'password' => Hash::make(1234567890),
        // ]);
        $this->call([
            SidebarWithPermissionSeeder::class,
            UomSeeder::class,
            ApprovalSeeder::class,
        ]);
        // Catalog::factory(10)->create();
        // Dealer::factory(10)->create();
        // Leasing::factory(10)->create();
        // Category::factory(2)->create();
        // Cluster::factory(10)->create();
        // SubCluster::factory(10)->create();
        // SubClusterItem::factory(10)->create();
        // Unit::factory(10)->create();
        // Asset::factory(50)->create();
        // AssetLeasing::factory(10)->create();
        // AssetInsurance::factory(10)->create();

        $user = User::query()->create([
            'nik' => 12345678,
            'name' => 'Administrator',
            'email' => 'administrator@tbu.co.id',
            'password' => Hash::make(1234567890),
        ]);
        $user->permissions()->sync(Permission::query()->pluck('id')->toArray());

        $this->call([
            AssetSeeder::class,
            CategorySeeder::class,
            ClusterSeeder::class,
            SubClusterSeeder::class,
            SubClusterItemSeeder::class,
            CatalogSeeder::class,
            DealerSeeder::class,
            LeasingSeeder::class,
            UnitSeeder::class,
            LifetimeSeeder::class,
        ]);
        Elasticsearch::setModel(Cer::class)->cleared();
    }
}
