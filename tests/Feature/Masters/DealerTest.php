<?php

namespace Tests\Feature\Masters;

use App\Models\Masters\Dealer;
use App\Models\User;
use Database\Seeders\SidebarWithPermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DealerTest extends TestCase
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
        $this->user->givePermission('dealer_read');
        $response = $this->actingAs($this->user)
            ->get(route('masters.dealers.index'));
        $response->assertSee('Data Dealer');
    }

    public function test_user_dosnt_have_access_index()
    {
        $response = $this->actingAs($this->user)
            ->get(route('masters.dealers.index'));
        $response->assertForbidden();
    }

    public function test_can_access_and_dosnt_have_any_data_datatable()
    {
        $this->user->givePermission('dealer_read');
        $response = $this->actingAs($this->user)
            ->post(route('masters.dealers.datatable'));

        $data = $response->json();
        $response->assertOk();
        $this->assertSame(0, $data['recordsTotal']);
    }

    public function test_can_access_and_with_data_datatable()
    {
        Dealer::factory(5)->create();
        $this->user->givePermission('dealer_read');
        $response = $this->actingAs($this->user)
            ->post(route('masters.dealers.datatable'));

        $data = $response->json();
        $response->assertOk();
        $this->assertSame(5, $data['recordsTotal']);
    }

    public function test_can_create_one_data()
    {
        $dealer = Dealer::factory()->make();
        $this->user->givePermission('dealer_create');
        $response = $this->actingAs($this->user)
            ->post(route('masters.dealers.store'), $dealer->toArray());

        $response->assertOk()
            ->assertJson([
                'message' => 'Berhasil disimpan'
            ]);
        $this->assertDatabaseCount(Dealer::class, 1);
    }

    public function test_create_dealer_with_invalid_data()
    {
        $dealer = Dealer::factory()->make([
            'name' => null
        ]);
        $this->user->givePermission('dealer_create');
        $response = $this->actingAs($this->user)
            ->post(route('masters.dealers.store'), $dealer->toArray());

        $response->assertInvalid();
        $this->assertDatabaseEmpty(Dealer::class);
    }

    public function test_can_edit_data()
    {
        $dealer = Dealer::factory()->create();
        $this->user->givePermission('dealer_update');
        $response = $this->actingAs($this->user)
            ->post(route('masters.dealers.edit', $dealer->getKey()));

        $response->assertOk();
        $response->assertJson($dealer->toArray());
    }

    public function test_access_edit_data_not_found()
    {
        $this->user->givePermission('dealer_update');
        $response = $this->actingAs($this->user)
            ->post(route('masters.dealers.edit', 1));

        $response->assertNotFound();
    }

    public function test_can_delete_data()
    {
        $dealer = Dealer::factory()->create();
        $this->user->givePermission('dealer_delete');
        $response = $this->actingAs($this->user)
            ->delete(route('masters.dealers.destroy', $dealer->getKey()));

        $response->assertOk();
        $response->assertJson([
            'message' => 'Berhasil dihapus'
        ]);
        $this->assertDatabaseEmpty(Dealer::class);
    }
}
