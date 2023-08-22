<?php

namespace Tests\Feature\Masters;

use App\Models\Masters\Cluster;
use App\Models\User;
use Database\Seeders\SidebarWithPermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ClusterTest extends TestCase
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
        $this->user->givePermission('cluster_read');
        $response = $this->actingAs($this->user)
            ->get(route('masters.clusters.index'));
        $response->assertSee('Data Cluster');
    }

    public function test_user_dosnt_have_access_index()
    {
        $response = $this->actingAs($this->user)
            ->get(route('masters.clusters.index'));
        $response->assertForbidden();
    }

    public function test_can_access_and_dosnt_have_any_data_datatable()
    {
        $this->user->givePermission('cluster_read');
        $response = $this->actingAs($this->user)
            ->post(route('masters.clusters.datatable'));

        $data = $response->json();
        $response->assertOk();
        $this->assertSame(0, $data['recordsTotal']);
    }

    public function test_can_access_and_with_data_datatable()
    {
        Cluster::factory(5)->create();
        $this->user->givePermission('cluster_read');
        $response = $this->actingAs($this->user)
            ->post(route('masters.clusters.datatable'));

        $data = $response->json();
        $response->assertOk();
        $this->assertSame(5, $data['recordsTotal']);
    }

    public function test_can_create_one_data()
    {
        $cluster = Cluster::factory()->make();
        $this->user->givePermission('cluster_create');
        $response = $this->actingAs($this->user)
            ->post(route('masters.clusters.store'), $cluster->toArray());

        $response->assertOk()
            ->assertJson([
                'message' => 'Berhasil disimpan'
            ]);
        $this->assertDatabaseCount(Cluster::class, 1);
    }

    public function test_create_cluster_with_invalid_data()
    {
        $cluster = Cluster::factory()->make([
            'name' => null
        ]);
        $this->user->givePermission('cluster_create');
        $response = $this->actingAs($this->user)
            ->post(route('masters.clusters.store'), $cluster->toArray());

        $response->assertInvalid();
        $this->assertDatabaseEmpty(Cluster::class);
    }

    public function test_can_edit_data()
    {
        $cluster = Cluster::factory()->create();
        $this->user->givePermission('cluster_update');
        $response = $this->actingAs($this->user)
            ->post(route('masters.clusters.edit', $cluster->getKey()));

        $response->assertOk();
        $response->assertJson($cluster->toArray());
    }

    public function test_access_edit_data_not_found()
    {
        $this->user->givePermission('cluster_update');
        $response = $this->actingAs($this->user)
            ->post(route('masters.clusters.edit', 1));

        $response->assertNotFound();
    }

    public function test_can_delete_data()
    {
        $cluster = Cluster::factory()->create();
        $this->user->givePermission('cluster_delete');
        $response = $this->actingAs($this->user)
            ->delete(route('masters.clusters.destroy', $cluster->getKey()));

        $response->assertOk();
        $response->assertJson([
            'message' => 'Berhasil dihapus'
        ]);
        $this->assertDatabaseEmpty(Cluster::class);
    }
}
