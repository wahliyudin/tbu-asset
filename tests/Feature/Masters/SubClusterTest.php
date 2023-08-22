<?php

namespace Tests\Feature\Masters;

use App\Models\Masters\Cluster;
use App\Models\Masters\SubCluster;
use App\Models\User;
use Database\Seeders\SidebarWithPermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SubClusterTest extends TestCase
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
        $cluster = Cluster::factory()->create();
        $this->user->givePermission('sub_cluster_read');
        $response = $this->actingAs($this->user)
            ->get(route('masters.sub-clusters.index'));

        $response->assertSee('Data Sub Cluster');
        $response->assertSeeText($cluster->name);
    }

    public function test_user_dosnt_have_access_index()
    {
        $response = $this->actingAs($this->user)
            ->get(route('masters.sub-clusters.index'));
        $response->assertForbidden();
    }

    public function test_can_access_and_dosnt_have_any_data_datatable()
    {
        $this->user->givePermission('sub_cluster_read');
        $response = $this->actingAs($this->user)
            ->post(route('masters.sub-clusters.datatable'));

        $data = $response->json();
        $response->assertOk();
        $this->assertSame(0, $data['recordsTotal']);
    }

    public function test_can_access_and_with_data_datatable()
    {
        SubCluster::factory(5)->create();
        $this->user->givePermission('sub_cluster_read');
        $response = $this->actingAs($this->user)
            ->post(route('masters.sub-clusters.datatable'));

        $data = $response->json();
        $response->assertOk();
        $this->assertSame(5, $data['recordsTotal']);
    }

    public function test_can_create_one_data()
    {
        $subCluster = SubCluster::factory()->make();
        $this->user->givePermission('sub_cluster_create');
        $response = $this->actingAs($this->user)
            ->post(route('masters.sub-clusters.store'), $subCluster->toArray());

        $response->assertOk()
            ->assertJson([
                'message' => 'Berhasil disimpan'
            ]);
        $this->assertDatabaseCount(SubCluster::class, 1);
    }

    public function test_create_sub_cluster_with_invalid_data()
    {
        $subCluster = SubCluster::factory()->make([
            'cluster_id' => 10,
        ]);
        $this->user->givePermission('sub_cluster_create');
        $response = $this->actingAs($this->user)
            ->post(route('masters.sub-clusters.store'), $subCluster->toArray());

        $response->assertInvalid();
        $this->assertDatabaseEmpty(SubCluster::class);
    }

    public function test_can_edit_data()
    {
        $subCluster = SubCluster::factory()->create();
        $this->user->givePermission('sub_cluster_update');
        $response = $this->actingAs($this->user)
            ->post(route('masters.sub-clusters.edit', $subCluster->getKey()));

        $response->assertOk();
        $response->assertJson($subCluster->toArray());
    }

    public function test_access_edit_data_not_found()
    {
        $this->user->givePermission('sub_cluster_update');
        $response = $this->actingAs($this->user)
            ->post(route('masters.sub-clusters.edit', 1));

        $response->assertNotFound();
    }

    public function test_can_delete_data()
    {
        $subCluster = SubCluster::factory()->create();
        $this->user->givePermission('sub_cluster_delete');
        $response = $this->actingAs($this->user)
            ->delete(route('masters.sub-clusters.destroy', $subCluster->getKey()));

        $response->assertOk();
        $response->assertJson([
            'message' => 'Berhasil dihapus'
        ]);
        $this->assertDatabaseEmpty(SubCluster::class);
    }
}
