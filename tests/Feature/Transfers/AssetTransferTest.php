<?php

namespace Tests\Feature\Transfers;

use App\Models\Assets\Asset;
use App\Models\Transfers\AssetTransfer;
use App\Models\User;
use Database\Seeders\SidebarWithPermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AssetTransferTest extends TestCase
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
        $this->user->givePermission('asset_transfer_read');
        $response = $this->actingAs($this->user)
            ->get(route('asset-transfers.index'));

        $response->assertSee('Data Transfer');
    }

    public function test_user_dosnt_have_access_index()
    {
        $response = $this->actingAs($this->user)
            ->get(route('asset-transfers.index'));
        $response->assertForbidden();
    }

    public function test_can_access_and_dosnt_have_any_data_datatable()
    {
        $this->user->givePermission('asset_transfer_read');
        $response = $this->actingAs($this->user)
            ->post(route('asset-transfers.datatable'));

        $data = $response->json();
        $response->assertOk();
        $this->assertSame(0, $data['recordsTotal']);
    }

    public function test_can_access_and_with_data_datatable()
    {
        AssetTransfer::factory(5)->create([
            'nik' => $this->user->nik
        ]);
        $this->user->givePermission('asset_transfer_read');
        $response = $this->actingAs($this->user)
            ->post(route('asset-transfers.datatable'));

        $data = $response->json();
        $response->assertOk();
        $this->assertSame(5, $data['recordsTotal']);
    }

    public function test_can_access_datatable_asset_status_idle()
    {
        Asset::factory()->create();
        $response = $this->actingAs($this->user)
            ->post(route('asset-transfers.datatable-asset'));

        $data = $response->json();
        $response->assertOk();
        $this->assertSame(1, $data['recordsTotal']);
    }

    public function test_access_method_show()
    {
        $assetTransfer = AssetTransfer::factory()->create();

        $this->user->givePermission('asset_transfer_read');
        $response = $this->actingAs($this->user)
            ->get(route('asset-transfers.show', $assetTransfer->getKey()));

        $response->assertSeeText('Data Show Transfer');
    }

    public function test_access_method_create()
    {
        $this->user->givePermission('asset_transfer_create');
        $response = $this->actingAs($this->user)
            ->get(route('asset-transfers.create'));

        $response->assertSeeText('Create Asset Transfer');
    }

    public function test_can_delete_data()
    {
        $assetTransfer = AssetTransfer::factory()->create();
        $this->user->givePermission('asset_transfer_delete');
        $response = $this->actingAs($this->user)
            ->delete(route('asset-transfers.destroy', $assetTransfer->getKey()));

        $response->assertOk();
        $response->assertJson([
            'message' => 'Berhasil dihapus'
        ]);
        $this->assertDatabaseEmpty(AssetTransfer::class);
    }
}
