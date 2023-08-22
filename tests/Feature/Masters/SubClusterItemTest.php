<?php

namespace Tests\Feature\Masters;

use App\Models\Masters\SubCluster;
use App\Models\Masters\SubClusterItem;
use App\Models\User;
use Database\Seeders\SidebarWithPermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SubClusterItemTest extends TestCase
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
        $subCluster = SubCluster::factory()->create();
        $this->user->givePermission('sub_cluster_item_read');
        $response = $this->actingAs($this->user)
            ->get(route('masters.sub-cluster-items.index'));

        $response->assertSee('Data Sub Cluster');
        $response->assertSeeText($subCluster->name);
    }

    public function test_user_dosnt_have_access_index()
    {
        $response = $this->actingAs($this->user)
            ->get(route('masters.sub-cluster-items.index'));
        $response->assertForbidden();
    }

    public function test_can_access_and_dosnt_have_any_data_datatable()
    {
        $this->user->givePermission('sub_cluster_item_read');
        $response = $this->actingAs($this->user)
            ->post(route('masters.sub-cluster-items.datatable'));

        $data = $response->json();
        $response->assertOk();
        $this->assertSame(0, $data['recordsTotal']);
    }

    public function test_can_access_and_with_data_datatable()
    {
        SubClusterItem::factory(5)->create();
        $this->user->givePermission('sub_cluster_item_read');
        $response = $this->actingAs($this->user)
            ->post(route('masters.sub-cluster-items.datatable'));

        $data = $response->json();
        $response->assertOk();
        $this->assertSame(5, $data['recordsTotal']);
    }

    public function test_can_create_one_data()
    {
        $subClusterItem = SubClusterItem::factory()->make();
        $this->user->givePermission('sub_cluster_item_create');
        $response = $this->actingAs($this->user)
            ->post(route('masters.sub-cluster-items.store'), $subClusterItem->toArray());

        $response->assertOk()
            ->assertJson([
                'message' => 'Berhasil disimpan'
            ]);
        $this->assertDatabaseCount(SubClusterItem::class, 1);
    }

    public function test_create_sub_cluster_item_with_invalid_data()
    {
        $subClusterItem = SubClusterItem::factory()->make([
            'sub_cluster_id' => 10,
        ]);
        $this->user->givePermission('sub_cluster_item_create');
        $response = $this->actingAs($this->user)
            ->post(route('masters.sub-cluster-items.store'), $subClusterItem->toArray());

        $response->assertInvalid();
        $this->assertDatabaseEmpty(SubClusterItem::class);
    }

    public function test_can_edit_data()
    {
        $subClusterItem = SubClusterItem::factory()->create();
        $this->user->givePermission('sub_cluster_item_update');
        $response = $this->actingAs($this->user)
            ->post(route('masters.sub-cluster-items.edit', $subClusterItem->getKey()));

        $response->assertOk();
        $response->assertJson($subClusterItem->toArray());
    }

    public function test_access_edit_data_not_found()
    {
        $this->user->givePermission('sub_cluster_item_update');
        $response = $this->actingAs($this->user)
            ->post(route('masters.sub-cluster-items.edit', 1));

        $response->assertNotFound();
    }

    public function test_can_delete_data()
    {
        $subClusterItem = SubClusterItem::factory()->create();
        $this->user->givePermission('sub_cluster_item_delete');
        $response = $this->actingAs($this->user)
            ->delete(route('masters.sub-cluster-items.destroy', $subClusterItem->getKey()));

        $response->assertOk();
        $response->assertJson([
            'message' => 'Berhasil dihapus'
        ]);
        $this->assertDatabaseEmpty(SubClusterItem::class);
    }
}
