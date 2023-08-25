<?php

namespace Tests\Feature\Assets;

use App\DataTransferObjects\Assets\AssetData;
use App\Models\Assets\Asset;
use App\Models\Assets\AssetInsurance;
use App\Models\Assets\AssetLeasing;
use App\Models\Masters\Dealer;
use App\Models\Masters\Leasing;
use App\Models\Masters\SubCluster;
use App\Models\Masters\Unit;
use App\Models\User;
use Database\Seeders\SidebarWithPermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AssetMasterTest extends TestCase
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
        $unit = Unit::factory()->create();
        $subCluster = SubCluster::factory()->create();
        $dealer = Dealer::factory()->create();
        $leasing = Leasing::factory()->create();

        $this->user->givePermission('asset_master_read');
        $response = $this->actingAs($this->user)
            ->get(route('asset-masters.index'));

        $response->assertSee('Data Asset');
        $response->assertSeeText($unit->model);
        $response->assertSeeText($subCluster->name);
        $response->assertSeeText($dealer->name);
        $response->assertSeeText($leasing->name);
    }

    public function test_user_dosnt_have_access_index()
    {
        $response = $this->actingAs($this->user)
            ->get(route('asset-masters.index'));
        $response->assertForbidden();
    }

    public function test_can_access_and_dosnt_have_any_data_datatable()
    {
        $this->user->givePermission('asset_master_read');
        $response = $this->actingAs($this->user)
            ->post(route('asset-masters.datatable'));

        $data = $response->json();
        $response->assertOk();
        $this->assertSame(0, $data['recordsTotal']);
    }

    public function test_can_access_and_with_data_datatable()
    {
        Asset::factory(5)->create();
        $this->user->givePermission('asset_master_read');
        $response = $this->actingAs($this->user)
            ->post(route('asset-masters.datatable'));

        $data = $response->json();
        $response->assertOk();
        $this->assertSame(5, $data['recordsTotal']);
    }


    public function test_can_create_one_data()
    {
        $asset = Asset::factory()->make();

        $insurance = AssetInsurance::factory()->make([
            'asset_id' => $asset->getKey()
        ]);
        $insurance = [
            'jangka_waktu_insurance' => $insurance->jangka_waktu,
            'biaya_insurance' => $insurance->biaya,
            'legalitas_insurance' => $insurance->legalitas,
        ];

        $leasing = AssetLeasing::factory()->make([
            'asset_id' => $asset->getKey()
        ]);
        $leasing = [
            'dealer_id_leasing' => $leasing->dealer_id,
            'leasing_id_leasing' => $leasing->leasing_id,
            'harga_beli_leasing' => $leasing->harga_beli,
            'jangka_waktu_leasing' => $leasing->jangka_waktu_leasing,
            'biaya_leasing' => $leasing->biaya_leasing,
            'legalitas_leasing' => $leasing->legalitas,
        ];

        $this->user->givePermission('asset_master_create');
        $response = $this->actingAs($this->user)
            ->post(route('asset-masters.store'), array_merge($asset->toArray(), $insurance, $leasing));

        $response->assertOk()
            ->assertJson([
                'message' => 'Berhasil disimpan'
            ]);
        $this->assertDatabaseCount(Asset::class, 1);
    }

    public function test_create_asset_master_with_invalid_data()
    {
        $asset = Asset::factory()->make([
            'kode' => null
        ]);
        $this->user->givePermission('asset_master_create');
        $response = $this->actingAs($this->user)
            ->post(route('asset-masters.store'), $asset->toArray());

        $response->assertInvalid();
        $this->assertDatabaseEmpty(Asset::class);
    }

    public function test_can_edit_data()
    {
        $asset = Asset::factory()->create();
        $this->user->givePermission('asset_master_update');
        $response = $this->actingAs($this->user)
            ->post(route('asset-masters.edit', $asset->getKey()));

        $response->assertOk();
        $response->assertJson(AssetData::from($asset)->toArray());
    }

    public function test_access_edit_data_not_found()
    {
        $this->user->givePermission('asset_master_update');
        $response = $this->actingAs($this->user)
            ->post(route('asset-masters.edit', 1));

        $response->assertNotFound();
    }

    public function test_can_delete_data()
    {
        $asset = Asset::factory()->create();
        $this->user->givePermission('asset_master_delete');
        $response = $this->actingAs($this->user)
            ->delete(route('asset-masters.destroy', $asset->getKey()));

        $response->assertOk();
        $response->assertJson([
            'message' => 'Berhasil dihapus'
        ]);
        $this->assertDatabaseEmpty(Asset::class);
    }
}
