<?php

namespace Tests\Feature\Cers;

use App\Models\Cers\Cer;
use App\Models\User;
use Database\Seeders\SidebarWithPermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CerTest extends TestCase
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
        $this->user->givePermission('asset_request_read');
        $response = $this->actingAs($this->user)
            ->get(route('asset-requests.index'));

        $response->assertSee('Data Cer');
    }

    public function test_user_dosnt_have_access_index()
    {
        $response = $this->actingAs($this->user)
            ->get(route('asset-requests.index'));
        $response->assertForbidden();
    }

    public function test_can_access_and_dosnt_have_any_data_datatable()
    {
        $this->user->givePermission('asset_request_read');
        $response = $this->actingAs($this->user)
            ->post(route('asset-requests.datatable'));

        $data = $response->json();
        $response->assertOk();
        $this->assertSame(0, $data['recordsTotal']);
    }

    public function test_can_access_and_with_data_datatable()
    {
        Cer::factory(5)->create();
        $this->user->givePermission('asset_request_read');
        $response = $this->actingAs($this->user)
            ->post(route('asset-requests.datatable'));

        $data = $response->json();
        $response->assertOk();
        $this->assertSame(5, $data['recordsTotal']);
    }

    // public function test_can_create_one_data()
    // {
    //     $cer = Cer::factory()->make();
    //     $this->user->givePermission('asset_request_create');
    //     $response = $this->actingAs($this->user)
    //         ->post(route('asset-requests.store'), $cer->toArray());

    //     $response->assertOk()
    //         ->assertJson([
    //             'message' => 'Berhasil disimpan'
    //         ]);
    //     $this->assertDatabaseCount(Cer::class, 1);
    // }

    // public function test_create_asset_request_with_invalid_data()
    // {
    //     $cer = Cer::factory()->make([
    //         'no_cer' => null
    //     ]);
    //     $this->user->givePermission('asset_request_create');
    //     $response = $this->actingAs($this->user)
    //         ->post(route('asset-requests.store'), $cer->toArray());

    //     $response->assertInvalid();
    //     $this->assertDatabaseEmpty(Cer::class);
    // }

    // public function test_can_edit_data()
    // {
    //     $cer = Cer::factory()->create();
    //     $this->user->givePermission('asset_request_update');
    //     $response = $this->actingAs($this->user)
    //         ->post(route('asset-requests.edit', $cer->getKey()));

    //     $response->assertOk();
    //     $response->assertJson($cer->toArray());
    // }

    // public function test_access_edit_data_not_found()
    // {
    //     $this->user->givePermission('asset_request_update');
    //     $response = $this->actingAs($this->user)
    //         ->post(route('asset-requests.edit', 1));

    //     $response->assertNotFound();
    // }

    public function test_can_delete_data()
    {
        $cer = Cer::factory()->create();
        $this->user->givePermission('asset_request_delete');
        $response = $this->actingAs($this->user)
            ->delete(route('asset-requests.destroy', $cer->getKey()));

        $response->assertOk();
        $response->assertJson([
            'message' => 'Berhasil dihapus'
        ]);
        $this->assertDatabaseEmpty(Cer::class);
    }
}
