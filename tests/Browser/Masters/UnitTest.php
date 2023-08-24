<?php

namespace Tests\Browser\Masters;

use App\Models\Masters\Unit;
use App\Models\User;
use Database\Seeders\SidebarWithPermissionSeeder;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class UnitTest extends DuskTestCase
{
    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(SidebarWithPermissionSeeder::class);
        $this->user = User::factory()->create();
    }

    public function test_can_not_access_index()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user->getKey())
                ->visitRoute('masters.units.index')
                ->assertTitle('Dilarang')
                ->assertSee('403');
        });
    }

    public function test_can_access_index()
    {
        $this->user->givePermission('unit_read');
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user->getKey())
                ->visitRoute('masters.units.index')
                ->assertTitle('Unit')
                ->assertSee('Data Unit');
        });
    }

    public function test_can_access_index_but_dosnt_have_permission_create()
    {
        $this->user->givePermission('unit_read');
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user->getKey())
                ->visitRoute('masters.units.index')
                ->assertTitle('Unit')
                ->assertSee('Data Unit')
                ->assertNotPresent('button[data-bs-target="#create-unit"]');
        });
    }

    public function test_can_access_index_and_have_permission_create()
    {
        $this->user->givePermissions(['unit_read', 'unit_create']);
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user->getKey())
                ->visitRoute('masters.units.index')
                ->assertTitle('Unit')
                ->assertSee('Data Unit')
                ->assertPresent('button[data-bs-target="#create-unit"]');
        });
    }

    public function test_can_access_index_but_dosnt_have_permission_edit()
    {
        $this->user->givePermission('unit_read');
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user->getKey())
                ->visitRoute('masters.units.index')
                ->assertTitle('Unit')
                ->assertSee('Data Unit')
                ->waitUntilMissing('#unit_table_processing')
                ->assertNotPresent('button.btn-edit');
        });
    }

    public function test_can_access_index_and_have_permission_edit()
    {
        $this->user->givePermissions(['unit_read', 'unit_update']);
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user->getKey())
                ->visitRoute('masters.units.index')
                ->assertTitle('Unit')
                ->assertSee('Data Unit')
                ->waitUntilMissing('#unit_table_processing')
                ->assertPresent('button.btn-edit');
        });
    }

    public function test_can_access_index_but_dosnt_have_permission_delete()
    {
        $this->user->givePermission('unit_read');
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user->getKey())
                ->visitRoute('masters.units.index')
                ->assertTitle('Unit')
                ->assertSee('Data Unit')
                ->waitUntilMissing('#unit_table_processing')
                ->assertNotPresent('button.btn-delete');
        });
    }

    public function test_can_access_index_and_have_permission_delete()
    {
        $this->user->givePermissions(['unit_read', 'unit_delete']);
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user->getKey())
                ->visitRoute('masters.units.index')
                ->assertTitle('Unit')
                ->assertSee('Data Unit')
                ->waitUntilMissing('#unit_table_processing')
                ->assertPresent('button.btn-delete');
        });
    }

    public function test_click_button_add_unit_and_then_modal_present()
    {
        $this->user->givePermissions(['unit_read', 'unit_create']);
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user->getKey())
                ->visitRoute('masters.units.index')
                ->click('button[data-bs-target="#create-unit"]')
                ->waitFor('#create-unit')
                ->assertSee('Tambah Unit');
        });
    }

    public function test_adding_data_via_modal()
    {
        $this->user->givePermissions(['unit_read', 'unit_create']);
        $this->browse(function (Browser $browser) {
            $unit = Unit::factory()->make();
            $browser->loginAs($this->user->getKey())
                ->visitRoute('masters.units.index')
                ->click('button[data-bs-target="#create-unit"]')
                ->waitFor('#create-unit')
                ->assertSee('Tambah Unit')
                ->type('input[name="kode"]', $unit->kode)
                ->type('input[name="model"]', $unit->model)
                ->type('input[name="type"]', $unit->type)
                ->type('input[name="seri"]', $unit->seri)
                ->type('input[name="class"]', $unit->class)
                ->type('input[name="brand"]', $unit->brand)
                ->type('input[name="serial_number"]', $unit->serial_number)
                ->type('input[name="spesification"]', $unit->spesification)
                ->type('input[name="tahun_pembuatan"]', $unit->tahun_pembuatan)
                ->press('button#create-unit_submit')
                ->waitUntilMissing('#create-unit_submit.indicator-progress')
                ->waitForText('successfully')
                ->click('button.swal2-confirm')
                ->waitFor('table#unit_table')
                ->waitUntilMissing('#unit_table_processing')
                ->type('input[data-kt-unit-table-filter="search"]', $unit->model)
                ->keys('input[data-kt-unit-table-filter="search"]', '{enter}')
                ->waitUntilMissing('#unit_table_processing')
                ->assertSee($unit->model);
        });
    }

    public function test_edit_data_via_modal()
    {
        $this->user->givePermissions(['unit_read', 'unit_update']);
        $this->browse(function (Browser $browser) {
            $unit = Unit::factory()->create();
            $newUnit = Unit::factory()->make();
            $browser->loginAs($this->user->getKey())
                ->visitRoute('masters.units.index')
                ->waitUntilMissing('#unit_table_processing')
                ->type('input[data-kt-unit-table-filter="search"]', $unit->model)
                ->keys('input[data-kt-unit-table-filter="search"]', '{enter}')
                ->waitUntilMissing('#unit_table_processing')
                ->click('button.btn-edit[data-unit="' . $unit->getKey() . '"]')
                ->waitFor('#create-unit')
                ->assertSee('Edit Unit')
                ->type('input[name="kode"]', $unit->kode)
                ->type('input[name="model"]', $unit->model)
                ->type('input[name="type"]', $unit->type)
                ->type('input[name="seri"]', $unit->seri)
                ->type('input[name="class"]', $unit->class)
                ->type('input[name="brand"]', $unit->brand)
                ->type('input[name="serial_number"]', $unit->serial_number)
                ->type('input[name="spesification"]', $unit->spesification)
                ->type('input[name="tahun_pembuatan"]', $unit->tahun_pembuatan)
                ->press('button#create-unit_submit')
                ->waitUntilMissing('#create-unit_submit.indicator-progress')
                ->waitFor('.swal2-container')
                ->click('button.swal2-confirm')
                ->waitFor('table#unit_table')
                ->click('#create-unit_close')
                ->click('button.swal2-confirm')
                ->waitUntilMissing('#unit_table_processing')
                ->type('input[data-kt-unit-table-filter="search"]', $newUnit->kode)
                ->keys('input[data-kt-unit-table-filter="search"]', '{enter}')
                ->waitUntilMissing('#unit_table_processing');
        });
    }

    public function test_delete_data()
    {
        $this->user->givePermissions(['unit_read', 'unit_delete']);
        $this->browse(function (Browser $browser) {
            $unit = Unit::factory()->create([
                'model' => 'Example Model'
            ]);
            $browser->loginAs($this->user->getKey())
                ->visitRoute('masters.units.index')
                ->waitUntilMissing('#unit_table_processing')
                ->type('input[data-kt-unit-table-filter="search"]', $unit->model)
                ->keys('input[data-kt-unit-table-filter="search"]', '{enter}')
                ->waitUntilMissing('#unit_table_processing')
                ->click('button.btn-delete[data-unit="' . $unit->getKey() . '"]')
                ->waitFor('div.swal2-popup.swal2-icon-warning')
                ->click('button.swal2-confirm')
                ->waitFor('div.swal2-popup.swal2-icon-success')
                ->click('button.swal2-confirm')
                ->waitUntilMissing('#unit_table_processing')
                ->type('input[data-kt-unit-table-filter="search"]', $unit->model)
                ->keys('input[data-kt-unit-table-filter="search"]', '{enter}')
                ->waitUntilMissing('#unit_table_processing')
                ->assertSee('No matching records found');
        });
    }
}
