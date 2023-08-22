<?php

namespace Tests\Feature\Masters;

use App\Models\Masters\Unit;
use App\Models\User;
use Database\Seeders\SidebarWithPermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UnitTest extends TestCase
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
        $this->user->givePermission('unit_read');
        $response = $this->actingAs($this->user)
            ->get(route('masters.units.index'));
        $response->assertSee('Data Unit');
    }

    public function test_user_dosnt_have_access_index()
    {
        $response = $this->actingAs($this->user)
            ->get(route('masters.units.index'));
        $response->assertForbidden();
    }

    public function test_can_access_and_dosnt_have_any_data_datatable()
    {
        $this->user->givePermission('unit_read');
        $response = $this->actingAs($this->user)
            ->post(route('masters.units.datatable'));

        $data = $response->json();
        $response->assertOk();
        $this->assertSame(0, $data['recordsTotal']);
    }

    public function test_can_access_and_with_data_datatable()
    {
        Unit::factory(5)->create();
        $this->user->givePermission('unit_read');
        $response = $this->actingAs($this->user)
            ->post(route('masters.units.datatable'));

        $data = $response->json();
        $response->assertOk();
        $this->assertSame(5, $data['recordsTotal']);
    }

    public function test_can_create_one_data()
    {
        $unit = Unit::factory()->make();
        $this->user->givePermission('unit_create');
        $response = $this->actingAs($this->user)
            ->post(route('masters.units.store'), $unit->toArray());

        $response->assertOk()
            ->assertJson([
                'message' => 'Berhasil disimpan'
            ]);
        $this->assertDatabaseCount(Unit::class, 1);
    }

    public function test_create_unit_with_invalid_data()
    {
        $unit = Unit::factory()->make([
            'kode' => null
        ]);
        $this->user->givePermission('unit_create');
        $response = $this->actingAs($this->user)
            ->post(route('masters.units.store'), $unit->toArray());

        $response->assertInvalid();
        $this->assertDatabaseEmpty(Unit::class);
    }

    public function test_can_edit_data()
    {
        $unit = Unit::factory()->create();
        $this->user->givePermission('unit_update');
        $response = $this->actingAs($this->user)
            ->post(route('masters.units.edit', $unit->getKey()));

        $response->assertOk();
        $response->assertJson($unit->toArray());
    }

    public function test_access_edit_data_not_found()
    {
        $this->user->givePermission('unit_update');
        $response = $this->actingAs($this->user)
            ->post(route('masters.units.edit', 1));

        $response->assertNotFound();
    }

    public function test_can_delete_data()
    {
        $unit = Unit::factory()->create();
        $this->user->givePermission('unit_delete');
        $response = $this->actingAs($this->user)
            ->delete(route('masters.units.destroy', $unit->getKey()));

        $response->assertOk();
        $response->assertJson([
            'message' => 'Berhasil dihapus'
        ]);
        $this->assertDatabaseEmpty(Unit::class);
    }
}
