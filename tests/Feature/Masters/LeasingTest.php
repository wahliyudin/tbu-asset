<?php

namespace Tests\Feature\Masters;

use App\Models\Masters\Leasing;
use App\Models\User;
use Database\Seeders\SidebarWithPermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LeasingTest extends TestCase
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
        $this->user->givePermission('leasing_read');
        $response = $this->actingAs($this->user)
            ->get(route('masters.leasings.index'));
        $response->assertSee('Data Leasing');
    }

    public function test_user_dosnt_have_access_index()
    {
        $response = $this->actingAs($this->user)
            ->get(route('masters.leasings.index'));
        $response->assertForbidden();
    }

    public function test_can_access_and_dosnt_have_any_data_datatable()
    {
        $this->user->givePermission('leasing_read');
        $response = $this->actingAs($this->user)
            ->post(route('masters.leasings.datatable'));

        $data = $response->json();
        $response->assertOk();
        $this->assertSame(0, $data['recordsTotal']);
    }

    public function test_can_access_and_with_data_datatable()
    {
        Leasing::factory(5)->create();
        $this->user->givePermission('leasing_read');
        $response = $this->actingAs($this->user)
            ->post(route('masters.leasings.datatable'));

        $data = $response->json();
        $response->assertOk();
        $this->assertSame(5, $data['recordsTotal']);
    }

    public function test_can_create_one_data()
    {
        $leasing = Leasing::factory()->make();
        $this->user->givePermission('leasing_create');
        $response = $this->actingAs($this->user)
            ->post(route('masters.leasings.store'), $leasing->toArray());

        $response->assertOk()
            ->assertJson([
                'message' => 'Berhasil disimpan'
            ]);
        $this->assertDatabaseCount(Leasing::class, 1);
    }

    public function test_create_leasing_with_invalid_data()
    {
        $leasing = Leasing::factory()->make([
            'name' => null
        ]);
        $this->user->givePermission('leasing_create');
        $response = $this->actingAs($this->user)
            ->post(route('masters.leasings.store'), $leasing->toArray());

        $response->assertInvalid();
        $this->assertDatabaseEmpty(Leasing::class);
    }

    public function test_can_edit_data()
    {
        $leasing = Leasing::factory()->create();
        $this->user->givePermission('leasing_update');
        $response = $this->actingAs($this->user)
            ->post(route('masters.leasings.edit', $leasing->getKey()));

        $response->assertOk();
        $response->assertJson($leasing->toArray());
    }

    public function test_access_edit_data_not_found()
    {
        $this->user->givePermission('leasing_update');
        $response = $this->actingAs($this->user)
            ->post(route('masters.leasings.edit', 1));

        $response->assertNotFound();
    }

    public function test_can_delete_data()
    {
        $leasing = Leasing::factory()->create();
        $this->user->givePermission('leasing_delete');
        $response = $this->actingAs($this->user)
            ->delete(route('masters.leasings.destroy', $leasing->getKey()));

        $response->assertOk();
        $response->assertJson([
            'message' => 'Berhasil dihapus'
        ]);
        $this->assertDatabaseEmpty(Leasing::class);
    }
}
