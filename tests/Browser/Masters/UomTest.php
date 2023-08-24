<?php

namespace Tests\Browser\Masters;

use App\Models\Masters\Uom;
use App\Models\User;
use Database\Seeders\SidebarWithPermissionSeeder;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class UomTest extends DuskTestCase
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
                ->visitRoute('masters.uoms.index')
                ->assertTitle('Dilarang')
                ->assertSee('403');
        });
    }

    public function test_can_access_index()
    {
        $this->user->givePermission('uom_read');
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user->getKey())
                ->visitRoute('masters.uoms.index')
                ->assertTitle('Uom')
                ->assertSee('Data Uom');
        });
    }

    public function test_can_access_index_but_dosnt_have_permission_create()
    {
        $this->user->givePermission('uom_read');
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user->getKey())
                ->visitRoute('masters.uoms.index')
                ->assertTitle('Uom')
                ->assertSee('Data Uom')
                ->assertNotPresent('button[data-bs-target="#create-uom"]');
        });
    }

    public function test_can_access_index_and_have_permission_create()
    {
        $this->user->givePermissions(['uom_read', 'uom_create']);
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user->getKey())
                ->visitRoute('masters.uoms.index')
                ->assertTitle('Uom')
                ->assertSee('Data Uom')
                ->assertPresent('button[data-bs-target="#create-uom"]');
        });
    }

    public function test_can_access_index_but_dosnt_have_permission_edit()
    {
        $this->user->givePermission('uom_read');
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user->getKey())
                ->visitRoute('masters.uoms.index')
                ->assertTitle('Uom')
                ->assertSee('Data Uom')
                ->waitUntilMissing('#uom_table_processing')
                ->assertNotPresent('button.btn-edit');
        });
    }

    public function test_can_access_index_and_have_permission_edit()
    {
        $this->user->givePermissions(['uom_read', 'uom_update']);
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user->getKey())
                ->visitRoute('masters.uoms.index')
                ->assertTitle('Uom')
                ->assertSee('Data Uom')
                ->waitUntilMissing('#uom_table_processing')
                ->assertPresent('button.btn-edit');
        });
    }

    public function test_can_access_index_but_dosnt_have_permission_delete()
    {
        $this->user->givePermission('uom_read');
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user->getKey())
                ->visitRoute('masters.uoms.index')
                ->assertTitle('Uom')
                ->assertSee('Data Uom')
                ->waitUntilMissing('#uom_table_processing')
                ->assertNotPresent('button.btn-delete');
        });
    }

    public function test_can_access_index_and_have_permission_delete()
    {
        $this->user->givePermissions(['uom_read', 'uom_delete']);
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user->getKey())
                ->visitRoute('masters.uoms.index')
                ->assertTitle('Uom')
                ->assertSee('Data Uom')
                ->waitUntilMissing('#uom_table_processing')
                ->assertPresent('button.btn-delete');
        });
    }

    public function test_click_button_add_uom_and_then_modal_present()
    {
        $this->user->givePermissions(['uom_read', 'uom_create']);
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user->getKey())
                ->visitRoute('masters.uoms.index')
                ->click('button[data-bs-target="#create-uom"]')
                ->waitFor('#create-uom')
                ->assertSee('Tambah Uom');
        });
    }

    public function test_adding_data_via_modal()
    {
        $this->user->givePermissions(['uom_read', 'uom_create']);
        $this->browse(function (Browser $browser) {
            $uom = Uom::factory()->make();
            $browser->loginAs($this->user->getKey())
                ->visitRoute('masters.uoms.index')
                ->click('button[data-bs-target="#create-uom"]')
                ->waitFor('#create-uom')
                ->assertSee('Tambah Uom')
                ->type('input[name="name"]', $uom->name)
                ->type('textarea[name="keterangan"]', $uom->keterangan)
                ->press('button#create-uom_submit')
                ->waitUntilMissing('#create-uom_submit.indicator-progress')
                ->waitForText('successfully')
                ->click('button.swal2-confirm')
                ->waitFor('table#uom_table')
                ->waitUntilMissing('#uom_table_processing')
                ->type('input[data-kt-uom-table-filter="search"]', $uom->name)
                ->keys('input[data-kt-uom-table-filter="search"]', '{enter}')
                ->waitUntilMissing('#uom_table_processing')
                ->assertSee($uom->name);
        });
    }

    public function test_edit_data_via_modal()
    {
        $this->user->givePermissions(['uom_read', 'uom_update']);
        $this->browse(function (Browser $browser) {
            $uom = Uom::factory()->create();
            $newUom = Uom::factory()->make();
            $browser->loginAs($this->user->getKey())
                ->visitRoute('masters.uoms.index')
                ->waitUntilMissing('#uom_table_processing')
                ->type('input[data-kt-uom-table-filter="search"]', $uom->name)
                ->keys('input[data-kt-uom-table-filter="search"]', '{enter}')
                ->waitUntilMissing('#uom_table_processing')
                ->click('button.btn-edit[data-uom="' . $uom->getKey() . '"]')
                ->waitFor('#create-uom')
                ->assertSee('Edit Uom')
                ->type('input[name="name"]', $uom->name)
                ->type('textarea[name="keterangan"]', $uom->keterangan)
                ->press('button#create-uom_submit')
                ->waitUntilMissing('#create-uom_submit.indicator-progress')
                ->waitFor('.swal2-container')
                ->click('button.swal2-confirm')
                ->waitFor('table#uom_table')
                ->click('#create-uom_close')
                ->click('button.swal2-confirm')
                ->waitUntilMissing('#uom_table_processing')
                ->type('input[data-kt-uom-table-filter="search"]', $newUom->name)
                ->keys('input[data-kt-uom-table-filter="search"]', '{enter}')
                ->waitUntilMissing('#uom_table_processing');
        });
    }

    public function test_delete_data()
    {
        $this->user->givePermissions(['uom_read', 'uom_delete']);
        $this->browse(function (Browser $browser) {
            $uom = Uom::factory()->create();
            $browser->loginAs($this->user->getKey())
                ->visitRoute('masters.uoms.index')
                ->waitUntilMissing('#uom_table_processing')
                ->type('input[data-kt-uom-table-filter="search"]', $uom->name)
                ->keys('input[data-kt-uom-table-filter="search"]', '{enter}')
                ->waitUntilMissing('#uom_table_processing')
                ->click('button.btn-delete[data-uom="' . $uom->getKey() . '"]')
                ->waitFor('div.swal2-popup.swal2-icon-warning')
                ->click('button.swal2-confirm')
                ->waitFor('div.swal2-popup.swal2-icon-success')
                ->click('button.swal2-confirm')
                ->waitUntilMissing('#uom_table_processing')
                ->type('input[data-kt-uom-table-filter="search"]', $uom->name)
                ->keys('input[data-kt-uom-table-filter="search"]', '{enter}')
                ->waitUntilMissing('#uom_table_processing')
                ->assertSee('No matching records found');
        });
    }
}
