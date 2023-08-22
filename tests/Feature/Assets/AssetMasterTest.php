<?php

namespace Tests\Feature\Assets;

use App\Models\Masters\Dealer;
use App\Models\Masters\Leasing;
use App\Models\Masters\SubCluster;
use App\Models\Masters\Unit;
use App\Models\User;
use Database\Seeders\SidebarWithPermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AssetMasterTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(SidebarWithPermissionSeeder::class);
        $this->user = User::factory()->create();
    }

    public function test_can_access_index()
    {
        $unit = Unit::factory()->create();
        $subCluster = SubCluster::factory()->create();
        $dealer = Dealer::factory()->create();
        $leasing = Leasing::factory()->create();

        $this->user->givePermission('asset_master_read');
        $response = $this->actingAs($this->user)
            ->get(route('asset-masters.index'));

        $response->assertSee('Data Asset');
        $response->assertSeeText($unit->model);
        $response->assertSeeText($subCluster->name);
        $response->assertSeeText($dealer->name);
        $response->assertSeeText($leasing->name);
    }
}
