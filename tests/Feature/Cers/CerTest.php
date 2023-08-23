<?php

namespace Tests\Feature\Cers;

use App\Enums\Asset\Status;
use App\Models\Assets\Asset;
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
        Cer::factory(5)->create([
            'nik' => $this->user->nik
        ]);
        $this->user->givePermission('asset_request_read');
        $response = $this->actingAs($this->user)
            ->post(route('asset-requests.datatable'));

        $data = $response->json();
        $response->assertOk();
        $this->assertSame(5, $data['recordsTotal']);
    }

    public function test_can_access_datatable_asset_status_idle()
    {
        Asset::factory()->create([
            'status' => Status::IDLE
        ]);
        $response = $this->actingAs($this->user)
            ->post(route('asset-requests.datatable-asset-idle'));

        $data = $response->json();
        $response->assertOk();
        $this->assertSame(1, $data['recordsTotal']);
    }

    public function test_access_method_show()
    {
        $cer = Cer::factory()->create();

        $this->user->givePermission('asset_request_read');
        $response = $this->actingAs($this->user)
            ->get(route('asset-requests.show', $cer->getKey()));

        $response->assertSeeText('Data Show Cer');
    }

    public function test_access_method_create()
    {
        $this->user->givePermission('asset_request_create');
        $response = $this->actingAs($this->user)
            ->get(route('asset-requests.create'));

        $response->assertSeeText('Create Cer');
    }

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
