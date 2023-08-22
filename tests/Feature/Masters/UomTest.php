<?php

namespace Tests\Feature\Masters;

use App\Models\Masters\Uom;
use App\Models\User;
use Database\Seeders\SidebarWithPermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UomTest extends TestCase
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
        $this->user->givePermission('uom_read');
        $response = $this->actingAs($this->user)
            ->get(route('masters.uoms.index'));
        $response->assertSee('Data Uom');
    }

    public function test_user_dosnt_have_access_index()
    {
        $response = $this->actingAs($this->user)
            ->get(route('masters.uoms.index'));
        $response->assertForbidden();
    }

    public function test_can_access_and_dosnt_have_any_data_datatable()
    {
        $this->user->givePermission('uom_read');
        $response = $this->actingAs($this->user)
            ->post(route('masters.uoms.datatable'));

        $data = $response->json();
        $response->assertOk();
        $this->assertSame(0, $data['recordsTotal']);
    }

    public function test_can_access_and_with_data_datatable()
    {
        Uom::factory(5)->create();
        $this->user->givePermission('uom_read');
        $response = $this->actingAs($this->user)
            ->post(route('masters.uoms.datatable'));

        $data = $response->json();
        $response->assertOk();
        $this->assertSame(5, $data['recordsTotal']);
    }

    public function test_can_create_one_data()
    {
        $uom = Uom::factory()->make();
        $this->user->givePermission('uom_create');
        $response = $this->actingAs($this->user)
            ->post(route('masters.uoms.store'), $uom->toArray());

        $response->assertOk()
            ->assertJson([
                'message' => 'Berhasil disimpan'
            ]);
        $this->assertDatabaseCount(Uom::class, 1);
    }

    public function test_create_uom_with_invalid_data()
    {
        $uom = Uom::factory()->make([
            'name' => null
        ]);
        $this->user->givePermission('uom_create');
        $response = $this->actingAs($this->user)
            ->post(route('masters.uoms.store'), $uom->toArray());

        $response->assertInvalid();
        $this->assertDatabaseEmpty(Uom::class);
    }

    public function test_can_edit_data()
    {
        $uom = Uom::factory()->create();
        $this->user->givePermission('uom_update');
        $response = $this->actingAs($this->user)
            ->post(route('masters.uoms.edit', $uom->getKey()));

        $response->assertOk();
        $response->assertJson($uom->toArray());
    }

    public function test_access_edit_data_not_found()
    {
        $this->user->givePermission('uom_update');
        $response = $this->actingAs($this->user)
            ->post(route('masters.uoms.edit', 1));

        $response->assertNotFound();
    }

    public function test_can_delete_data()
    {
        $uom = Uom::factory()->create();
        $this->user->givePermission('uom_delete');
        $response = $this->actingAs($this->user)
            ->delete(route('masters.uoms.destroy', $uom->getKey()));

        $response->assertOk();
        $response->assertJson([
            'message' => 'Berhasil dihapus'
        ]);
        $this->assertDatabaseEmpty(Uom::class);
    }
}
