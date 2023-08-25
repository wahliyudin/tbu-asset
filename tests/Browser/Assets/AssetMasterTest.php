<?php

namespace Tests\Browser\Assets;

use App\Enums\Asset\Status;
use App\Helpers\Helper;
use App\Models\Assets\Asset;
use App\Models\Assets\AssetInsurance;
use App\Models\Assets\AssetLeasing;
use App\Models\Masters\Dealer;
use App\Models\Masters\Leasing;
use App\Models\Masters\SubCluster;
use App\Models\Masters\Unit;
use App\Models\User;
use Carbon\Carbon;
use Database\Seeders\SidebarWithPermissionSeeder;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class AssetMasterTest extends DuskTestCase
{
    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->artisan('migrate:fresh');
        $this->seed(SidebarWithPermissionSeeder::class);
        $this->user = User::factory()->create();
    }

    public function test_can_not_access_index()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user->getKey())
                ->visitRoute('asset-masters.index')
                ->assertTitle('Dilarang')
                ->assertSee('403');
        });
    }

    public function test_can_access_index()
    {
        $this->user->givePermission('asset_master_read');
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user->getKey())
                ->visitRoute('asset-masters.index')
                ->assertTitle('Asset')
                ->assertSee('Data Asset');
        });
    }

    public function test_can_access_index_but_dosnt_have_permission_create()
    {
        $this->user->givePermission('asset_master_read');
        $this->browse(function (Browser $browser) {
            Asset::factory()->create();

            $browser->loginAs($this->user->getKey())
                ->visitRoute('asset-masters.index')
                ->assertTitle('Asset')
                ->assertSee('Data Asset')
                ->assertNotPresent('button[data-bs-target="#create-asset"]');
        });
    }

    public function test_can_access_index_and_have_permission_create()
    {
        $this->user->givePermissions(['asset_master_read', 'asset_master_create']);
        $this->browse(function (Browser $browser) {
            Asset::factory()->create();

            $browser->loginAs($this->user->getKey())
                ->visitRoute('asset-masters.index')
                ->assertTitle('Asset')
                ->assertSee('Data Asset')
                ->assertPresent('button[data-bs-target="#create-asset"]');
        });
    }

    public function test_can_access_index_but_dosnt_have_permission_edit()
    {
        $this->user->givePermission('asset_master_read');
        $this->browse(function (Browser $browser) {
            Asset::factory()->create();

            $browser->loginAs($this->user->getKey())
                ->visitRoute('asset-masters.index')
                ->assertTitle('Asset')
                ->assertSee('Data Asset')
                ->waitUntilMissing('#asset_master_table_processing')
                ->assertNotPresent('button.btn-edit');
        });
    }

    public function test_can_access_index_and_have_permission_edit()
    {
        $this->user->givePermissions(['asset_master_read', 'asset_master_update']);
        $this->browse(function (Browser $browser) {
            Asset::factory()->create();

            $browser->loginAs($this->user->getKey())
                ->visitRoute('asset-masters.index')
                ->assertTitle('Asset')
                ->assertSee('Data Asset')
                ->waitUntilMissing('#asset_master_table_processing')
                ->assertPresent('button.btn-edit');
        });
    }

    public function test_can_access_index_but_dosnt_have_permission_delete()
    {
        $this->user->givePermission('asset_master_read');
        $this->browse(function (Browser $browser) {
            Asset::factory()->create();

            $browser->loginAs($this->user->getKey())
                ->visitRoute('asset-masters.index')
                ->assertTitle('Asset')
                ->assertSee('Data Asset')
                ->waitUntilMissing('#asset_master_table_processing')
                ->assertNotPresent('button.btn-delete');
        });
    }

    public function test_can_access_index_and_have_permission_delete()
    {
        $this->user->givePermissions(['asset_master_read', 'asset_master_delete']);
        $this->browse(function (Browser $browser) {
            Asset::factory()->create();

            $browser->loginAs($this->user->getKey())
                ->visitRoute('asset-masters.index')
                ->assertTitle('Asset')
                ->assertSee('Data Asset')
                ->waitUntilMissing('#asset_master_table_processing')
                ->assertPresent('button.btn-delete');
        });
    }

    public function test_click_button_add_asset_master_and_then_modal_present()
    {
        $this->user->givePermissions(['asset_master_read', 'asset_master_create']);
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user->getKey())
                ->visitRoute('asset-masters.index')
                ->click('button[data-bs-target="#create-asset"]')
                ->waitFor('#create-asset')
                ->assertSee('Tambah Asset');
        });
    }

    public function test_adding_data_via_modal()
    {
        $this->user->givePermissions(['asset_master_read', 'asset_master_create']);

        $this->browse(function (Browser $browser) {
            $unit = Unit::factory()->create();
            $subCluster = SubCluster::factory()->create();
            $assetMaster = Asset::factory()->make([
                'kode' => 'Unique Code',
                'tgl_bast' => now()->format('Y-m-d')
            ]);
            $tglBast = Carbon::make($assetMaster->tgl_bast)->format('F d, Y');

            $dealer = Dealer::factory()->create();
            $leasing = Leasing::factory()->create();
            $assetLeasing = AssetLeasing::factory()->make([
                'asset_id' => $assetMaster->getKey()
            ]);

            $assetInsurance = AssetInsurance::factory()->make([
                'asset_id' => $assetMaster->getKey()
            ]);

            $browser->macro('select2SearchAndSelect', function ($selector, $searchText) {
                return $this->click("$selector ~ span.select2.select2-container")
                    ->waitFor("$selector ~ span.select2-container span.select2-dropdown")
                    ->type("$selector ~ span.select2-container input.select2-search__field", $searchText)
                    ->waitFor("$selector ~ span.select2-container .select2-results__options")
                    ->click("$selector ~ span.select2-container li.select2-results__option:first-child")
                    ->assertSeeIn("$selector ~ span.select2-container span.select2-selection__rendered", $searchText);
            });
            $browser->macro('flatPickr', function ($selector, $date) {
                return $this->click($selector)
                    ->waitFor('.flatpickr-calendar')
                    ->click('.flatpickr-days .flatpickr-day[aria-label="' . $date . '"]')
                    ->assertPresent('.flatpickr-days .flatpickr-day[aria-label="' . $date . '"].selected');
            });

            $r = $browser->loginAs($this->user->getKey())
                ->visitRoute('asset-masters.index')
                ->click('button[data-bs-target="#create-asset"]')
                ->waitFor('#create-asset')
                ->assertSee('Tambah Asset')

                ->type('input[name="kode"]', $assetMaster->kode)
                ->select2SearchAndSelect('select[name="unit_id"]', $unit->model)
                ->select2SearchAndSelect('select[name="sub_cluster_id"]', $subCluster->name)
                ->type('input[name="member_name"]', $assetMaster->member_name)
                ->assertValue('input[name="member_name"]', $assetMaster->member_name)
                // ->select2SearchAndSelect('select[name="pic"]', 'MUHAMMAD NUR')
                ->type('input[name="activity"]', $assetMaster->activity)
                ->assertValue('input[name="activity"]', $assetMaster->activity)
                ->type('input[name="asset_location"]', $assetMaster->asset_location)
                ->assertValue('input[name="asset_location"]', $assetMaster->asset_location)
                ->type('input[name="kondisi"]', $assetMaster->kondisi)
                ->assertValue('input[name="kondisi"]', $assetMaster->kondisi)
                ->type('input[name="uom"]', $assetMaster->uom)
                ->assertValue('input[name="uom"]', $assetMaster->uom)
                ->type('input[name="quantity"]', $assetMaster->quantity)
                ->assertValue('input[name="quantity"]', $assetMaster->quantity)
                ->flatPickr('input[name="tgl_bast"]', $tglBast)
                ->type('input[name="hm"]', $assetMaster->hm)
                ->assertValue('input[name="hm"]', $assetMaster->hm)
                ->type('input[name="pr_number"]', $assetMaster->pr_number)
                ->assertValue('input[name="pr_number"]', $assetMaster->pr_number)
                ->type('input[name="po_number"]', $assetMaster->po_number)
                ->assertValue('input[name="po_number"]', $assetMaster->po_number)
                ->type('input[name="gr_number"]', $assetMaster->gr_number)
                ->assertValue('input[name="gr_number"]', $assetMaster->gr_number)
                ->type('input[name="remark"]', $assetMaster->remark)
                ->assertValue('input[name="remark"]', $assetMaster->remark)
                ->select2SearchAndSelect('select[name="status"]', Status::ACTIVE->label())

                ->click('ul.nav.nav-tabs li a[href="#leasing"]')
                ->assertPresent('select[name="dealer_id_leasing"]')
                ->select2SearchAndSelect('select[name="dealer_id_leasing"]', $dealer->name)
                ->select2SearchAndSelect('select[name="leasing_id_leasing"]', $leasing->name)
                ->type('input[name="harga_beli_leasing"]', $assetLeasing->harga_beli)
                ->assertValue('input[name="harga_beli_leasing"]', Helper::formatRupiah($assetLeasing->harga_beli))
                ->type('input[name="jangka_waktu_leasing"]', $assetLeasing->jangka_waktu_leasing)
                ->assertValue('input[name="jangka_waktu_leasing"]', $assetLeasing->jangka_waktu_leasing)
                ->type('input[name="biaya_leasing"]', $assetLeasing->biaya_leasing)
                ->assertValue('input[name="biaya_leasing"]', Helper::formatRupiah($assetLeasing->biaya_leasing))
                ->type('input[name="legalitas_leasing"]', $assetLeasing->legalitas)
                ->assertValue('input[name="legalitas_leasing"]', $assetLeasing->legalitas)

                ->click('ul.nav.nav-tabs li a[href="#asuransi"]')
                ->assertPresent('input[name="jangka_waktu_insurance"]')
                ->type('input[name="jangka_waktu_insurance"]', $assetInsurance->jangka_waktu)
                ->assertValue('input[name="jangka_waktu_insurance"]', $assetInsurance->jangka_waktu)
                ->type('input[name="biaya_insurance"]', $assetInsurance->biaya)
                ->assertValue('input[name="biaya_insurance"]', Helper::formatRupiah($assetInsurance->biaya))
                ->type('input[name="legalitas_insurance"]', $assetInsurance->legalitas)
                ->assertValue('input[name="legalitas_insurance"]', $assetInsurance->legalitas)

                ->press('button#create-asset_submit')
                ->waitUntilMissing('#create-asset_submit.indicator-progress')
                ->assertNotPresent('div.fv-plugins-message-container.invalid-feedback div[data-field="unit_id"]')
                ->assertNotPresent('div.fv-plugins-message-container.invalid-feedback div[data-field="sub_cluster_id"]')
                ->assertNotPresent('div.fv-plugins-message-container.invalid-feedback div[data-field="member_name"]')
                ->assertNotPresent('div.fv-plugins-message-container.invalid-feedback div[data-field="pic"]')
                ->assertNotPresent('div.fv-plugins-message-container.invalid-feedback div[data-field="activity"]')
                ->assertNotPresent('div.fv-plugins-message-container.invalid-feedback div[data-field="asset_location"]')
                ->assertNotPresent('div.fv-plugins-message-container.invalid-feedback div[data-field="kondisi"]')
                ->assertNotPresent('div.fv-plugins-message-container.invalid-feedback div[data-field="uom"]')
                ->assertNotPresent('div.fv-plugins-message-container.invalid-feedback div[data-field="quantity"]')
                ->assertNotPresent('div.fv-plugins-message-container.invalid-feedback div[data-field="tgl_bast"]')
                ->assertNotPresent('div.fv-plugins-message-container.invalid-feedback div[data-field="hm"]')
                ->assertNotPresent('div.fv-plugins-message-container.invalid-feedback div[data-field="pr_number"]')
                ->assertNotPresent('div.fv-plugins-message-container.invalid-feedback div[data-field="po_number"]')
                ->assertNotPresent('div.fv-plugins-message-container.invalid-feedback div[data-field="gr_number"]')
                ->assertNotPresent('div.fv-plugins-message-container.invalid-feedback div[data-field="remark"]')
                ->assertNotPresent('div.fv-plugins-message-container.invalid-feedback div[data-field="status"]')
                ->assertNotPresent('div.fv-plugins-message-container.invalid-feedback div[data-field="dealer_id_leasing"]')
                ->assertNotPresent('div.fv-plugins-message-container.invalid-feedback div[data-field="leasing_id_leasing"]')
                ->assertNotPresent('div.fv-plugins-message-container.invalid-feedback div[data-field="harga_beli_leasing"]')
                ->assertNotPresent('div.fv-plugins-message-container.invalid-feedback div[data-field="jangka_waktu_leasing"]')
                ->assertNotPresent('div.fv-plugins-message-container.invalid-feedback div[data-field="biaya_leasing"]')
                ->assertNotPresent('div.fv-plugins-message-container.invalid-feedback div[data-field="legalitas_leasing"]')
                ->assertNotPresent('div.fv-plugins-message-container.invalid-feedback div[data-field="jangka_waktu_insurance"]')
                ->assertNotPresent('div.fv-plugins-message-container.invalid-feedback div[data-field="biaya_insurance"]')
                ->assertNotPresent('div.fv-plugins-message-container.invalid-feedback div[data-field="legalitas_insurance"]')
                // ->assertPresent('div.swal2-popup.swal2-modal.swal2-icon-success.swal2-show')
                // ->click('div.swal2-popup.swal2-modal.swal2-icon-success.swal2-show button.swal2-confirm')
                ->click('div#create-asset_close')
                ->click('button.swal2-confirm')
                ->waitFor('table#asset_table')
                ->waitUntilMissing('#asset_table_processing')
                ->type('input[data-kt-asset-table-filter="search"]', $assetMaster->kode)
                ->keys('input[data-kt-asset-table-filter="search"]', '{enter}')
                ->waitUntilMissing('#asset_table_processing')
                ->assertSee($assetMaster->kode);
        });
    }

    public function test_edit_data_via_modal()
    {
        $this->user->givePermissions(['asset_master_read', 'asset_master_update']);
        $this->browse(function (Browser $browser) {
            $assetMaster = Asset::factory()->create([
                'kode' => 'Code Edit'
            ]);

            $assetLeasing = AssetLeasing::factory()->create([
                'asset_id' => $assetMaster->getKey()
            ]);

            $assetInsurance = AssetInsurance::factory()->create([
                'asset_id' => $assetMaster->getKey()
            ]);

            $browser->loginAs($this->user->getKey())
                ->visitRoute('asset-masters.index')
                ->waitUntilMissing('#asset_table_processing')
                ->type('input[data-kt-asset-table-filter="search"]', $assetMaster->kode)
                ->keys('input[data-kt-asset-table-filter="search"]', '{enter}')
                ->waitUntilMissing('#asset_table_processing')
                ->click('button.btn-edit[data-asset="' . $assetMaster->getKey() . '"]')
                ->waitFor('#create-asset')
                ->assertSee('Edit Asset')
                ->assertValue('input[name="member_name"]', $assetMaster->member_name)
                ->assertValue('input[name="activity"]', $assetMaster->activity)
                ->assertValue('input[name="asset_location"]', $assetMaster->asset_location)
                ->assertValue('input[name="kondisi"]', $assetMaster->kondisi)
                ->assertValue('input[name="uom"]', $assetMaster->uom)
                ->assertValue('input[name="quantity"]', $assetMaster->quantity)
                ->assertValue('input[name="hm"]', $assetMaster->hm)
                ->assertValue('input[name="pr_number"]', $assetMaster->pr_number)
                ->assertValue('input[name="po_number"]', $assetMaster->po_number)
                ->assertValue('input[name="gr_number"]', $assetMaster->gr_number)
                ->assertValue('input[name="remark"]', $assetMaster->remark)

                ->click('ul.nav.nav-tabs li a[href="#leasing"]')
                ->assertValue('input[name="harga_beli_leasing"]', Helper::formatRupiah($assetLeasing->harga_beli))
                ->assertValue('input[name="jangka_waktu_leasing"]', $assetLeasing->jangka_waktu_leasing)
                ->assertValue('input[name="biaya_leasing"]', Helper::formatRupiah($assetLeasing->biaya_leasing))
                ->assertValue('input[name="legalitas_leasing"]', $assetLeasing->legalitas)

                ->click('ul.nav.nav-tabs li a[href="#asuransi"]')
                ->assertValue('input[name="jangka_waktu_insurance"]', $assetInsurance->jangka_waktu)
                ->assertValue('input[name="biaya_insurance"]', Helper::formatRupiah($assetInsurance->biaya))
                ->assertValue('input[name="legalitas_insurance"]', $assetInsurance->legalitas)
                ->press('button#create-asset_submit')
                ->waitUntilMissing('#create-asset_submit.indicator-progress')
                ->waitFor('div.swal2-container')
                ->assertPresent('div.swal2-popup.swal2-modal.swal2-icon-success.swal2-show')
                ->click('div.swal2-popup.swal2-modal.swal2-icon-success.swal2-show button.swal2-confirm')
                ->waitFor('table#asset_table')
                ->waitUntilMissing('#asset_table_processing')
                ->type('input[data-kt-asset-table-filter="search"]', $assetMaster->kode)
                ->keys('input[data-kt-asset-table-filter="search"]', '{enter}')
                ->waitUntilMissing('#asset_table_processing')
                ->assertSee($assetMaster->kode);
        });
    }

    public function test_delete_data()
    {
        $this->user->givePermissions(['asset_master_read', 'asset_master_delete']);
        $this->browse(function (Browser $browser) {
            $assetMaster = Asset::factory()->create([
                'kode' => 'Code Delete'
            ]);
            $browser->loginAs($this->user->getKey())
                ->visitRoute('asset-masters.index')
                ->waitUntilMissing('#asset_table_processing')
                ->type('input[data-kt-asset-table-filter="search"]', $assetMaster->kode)
                ->keys('input[data-kt-asset-table-filter="search"]', '{enter}')
                ->waitUntilMissing('#asset_table_processing')
                ->click('button.btn-delete[data-asset="' . $assetMaster->getKey() . '"]')
                ->waitFor('div.swal2-popup.swal2-icon-warning')
                ->click('button.swal2-confirm')
                ->waitFor('div.swal2-popup.swal2-icon-success')
                ->click('button.swal2-confirm')
                ->waitUntilMissing('#asset_table_processing')
                ->type('input[data-kt-asset-table-filter="search"]', $assetMaster->kode)
                ->keys('input[data-kt-asset-table-filter="search"]', '{enter}')
                ->waitUntilMissing('#asset_table_processing')
                ->assertSee('No matching records found');
        });
    }
}
