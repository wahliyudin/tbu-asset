<?php

namespace Tests\Feature\Disposes;

use App\Models\Assets\Asset;
use App\Models\Disposes\AssetDispose;
use App\Models\User;
use Database\Seeders\SidebarWithPermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AssetDisposeTest extends TestCase
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
        $this->user->givePermission('asset_dispose_read');
        $response = $this->actingAs($this->user)
            ->get(route('asset-disposes.index'));

        $response->assertSee('Data Dispose');
    }

    public function test_user_dosnt_have_access_index()
    {
        $response = $this->actingAs($this->user)
            ->get(route('asset-disposes.index'));
        $response->assertForbidden();
    }

    public function test_can_access_and_dosnt_have_any_data_datatable()
    {
        $this->user->givePermission('asset_dispose_read');
        $response = $this->actingAs($this->user)
            ->post(route('asset-disposes.datatable'));

        $data = $response->json();
        $response->assertOk();
        $this->assertSame(0, $data['recordsTotal']);
    }

    public function test_can_access_and_with_data_datatable()
    {
        AssetDispose::factory(5)->create([
            'nik' => $this->user->nik
        ]);
        $this->user->givePermission('asset_dispose_read');
        $response = $this->actingAs($this->user)
            ->post(route('asset-disposes.datatable'));

        $data = $response->json();
        $response->assertOk();
        $this->assertSame(5, $data['recordsTotal']);
    }

    public function test_can_access_datatable_asset_status_idle()
    {
        Asset::factory()->create();
        $response = $this->actingAs($this->user)
            ->post(route('asset-disposes.datatable-asset'));

        $data = $response->json();
        $response->assertOk();
        $this->assertSame(1, $data['recordsTotal']);
    }

    public function test_access_method_show()
    {
        $assetDispose = AssetDispose::factory()->create();

        $this->user->givePermission('asset_dispose_read');
        $response = $this->actingAs($this->user)
            ->get(route('asset-disposes.show', $assetDispose->getKey()));

        $response->assertSeeText('Data Show Dispose');
    }

    public function test_access_method_create()
    {
        $this->user->givePermission('asset_dispose_create');
        $response = $this->actingAs($this->user)
            ->get(route('asset-disposes.create'));

        $response->assertSeeText('Create Asset Dispose');
    }

    public function test_can_delete_data()
    {
        $assetDispose = AssetDispose::factory()->create();
        $this->user->givePermission('asset_dispose_delete');
        $response = $this->actingAs($this->user)
            ->delete(route('asset-disposes.destroy', $assetDispose->getKey()));

        $response->assertOk();
        $response->assertJson([
            'message' => 'Berhasil dihapus'
        ]);
        $this->assertDatabaseEmpty(AssetDispose::class);
    }
}
