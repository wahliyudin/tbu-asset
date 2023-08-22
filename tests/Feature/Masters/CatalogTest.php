<?php

namespace Tests\Feature\Masters;

use App\Models\Masters\Catalog;
use App\Models\User;
use Database\Seeders\SidebarWithPermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CatalogTest extends TestCase
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
        $this->user->givePermission('catalog_read');
        $response = $this->actingAs($this->user)
            ->get(route('masters.catalogs.index'));
        $response->assertSee('Data Catalog');
    }

    public function test_user_dosnt_have_access_index()
    {
        $response = $this->actingAs($this->user)
            ->get(route('masters.catalogs.index'));
        $response->assertForbidden();
    }

    public function test_can_access_and_dosnt_have_any_data_datatable()
    {
        $this->user->givePermission('catalog_read');
        $response = $this->actingAs($this->user)
            ->post(route('masters.catalogs.datatable'));

        $data = $response->json();
        $response->assertOk();
        $this->assertSame(0, $data['recordsTotal']);
    }

    public function test_can_access_and_with_data_datatable()
    {
        Catalog::factory(5)->create();
        $this->user->givePermission('catalog_read');
        $response = $this->actingAs($this->user)
            ->post(route('masters.catalogs.datatable'));

        $data = $response->json();
        $response->assertOk();
        $this->assertSame(5, $data['recordsTotal']);
    }

    public function test_can_create_one_data()
    {
        $catalog = Catalog::factory()->make();
        $this->user->givePermission('catalog_create');
        $response = $this->actingAs($this->user)
            ->post(route('masters.catalogs.store'), $catalog->toArray());

        $response->assertOk()
            ->assertJson([
                'message' => 'Berhasil disimpan'
            ]);
        $this->assertDatabaseCount(Catalog::class, 1);
    }

    public function test_create_catalog_with_invalid_data()
    {
        $catalog = Catalog::factory()->make([
            'unit_model' => null
        ]);
        $this->user->givePermission('catalog_create');
        $response = $this->actingAs($this->user)
            ->post(route('masters.catalogs.store'), $catalog->toArray());

        $response->assertInvalid();
        $this->assertDatabaseEmpty(Catalog::class);
    }

    public function test_can_edit_data()
    {
        $catalog = Catalog::factory()->create();
        $this->user->givePermission('catalog_update');
        $response = $this->actingAs($this->user)
            ->post(route('masters.catalogs.edit', $catalog->getKey()));

        $response->assertOk();
        $response->assertJson($catalog->toArray());
    }

    public function test_access_edit_data_not_found()
    {
        $this->user->givePermission('catalog_update');
        $response = $this->actingAs($this->user)
            ->post(route('masters.catalogs.edit', 1));

        $response->assertNotFound();
    }

    public function test_can_delete_data()
    {
        $catalog = Catalog::factory()->create();
        $this->user->givePermission('catalog_delete');
        $response = $this->actingAs($this->user)
            ->delete(route('masters.catalogs.destroy', $catalog->getKey()));

        $response->assertOk();
        $response->assertJson([
            'message' => 'Berhasil dihapus'
        ]);
        $this->assertDatabaseEmpty(Catalog::class);
    }
}
