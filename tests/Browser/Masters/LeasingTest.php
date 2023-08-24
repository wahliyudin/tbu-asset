<?php

namespace Tests\Browser\Masters;

use App\Models\Masters\Leasing;
use App\Models\User;
use Database\Seeders\SidebarWithPermissionSeeder;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LeasingTest extends DuskTestCase
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
                ->visitRoute('masters.leasings.index')
                ->assertTitle('Dilarang')
                ->assertSee('403');
        });
    }

    public function test_can_access_index()
    {
        $this->user->givePermission('leasing_read');
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user->getKey())
                ->visitRoute('masters.leasings.index')
                ->assertTitle('Leasing')
                ->assertSee('Data Leasing');
        });
    }

    public function test_can_access_index_but_dosnt_have_permission_create()
    {
        $this->user->givePermission('leasing_read');
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user->getKey())
                ->visitRoute('masters.leasings.index')
                ->assertTitle('Leasing')
                ->assertSee('Data Leasing')
                ->assertNotPresent('button[data-bs-target="#create-leasing"]');
        });
    }

    public function test_can_access_index_and_have_permission_create()
    {
        $this->user->givePermissions(['leasing_read', 'leasing_create']);
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user->getKey())
                ->visitRoute('masters.leasings.index')
                ->assertTitle('Leasing')
                ->assertSee('Data Leasing')
                ->assertPresent('button[data-bs-target="#create-leasing"]');
        });
    }

    public function test_can_access_index_but_dosnt_have_permission_edit()
    {
        $this->user->givePermission('leasing_read');
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user->getKey())
                ->visitRoute('masters.leasings.index')
                ->assertTitle('Leasing')
                ->assertSee('Data Leasing')
                ->waitUntilMissing('#leasing_table_processing')
                ->assertNotPresent('button.btn-edit');
        });
    }

    public function test_can_access_index_and_have_permission_edit()
    {
        $this->user->givePermissions(['leasing_read', 'leasing_update']);
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user->getKey())
                ->visitRoute('masters.leasings.index')
                ->assertTitle('Leasing')
                ->assertSee('Data Leasing')
                ->waitUntilMissing('#leasing_table_processing')
                ->assertPresent('button.btn-edit');
        });
    }

    public function test_can_access_index_but_dosnt_have_permission_delete()
    {
        $this->user->givePermission('leasing_read');
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user->getKey())
                ->visitRoute('masters.leasings.index')
                ->assertTitle('Leasing')
                ->assertSee('Data Leasing')
                ->waitUntilMissing('#leasing_table_processing')
                ->assertNotPresent('button.btn-delete');
        });
    }

    public function test_can_access_index_and_have_permission_delete()
    {
        $this->user->givePermissions(['leasing_read', 'leasing_delete']);
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user->getKey())
                ->visitRoute('masters.leasings.index')
                ->assertTitle('Leasing')
                ->assertSee('Data Leasing')
                ->waitUntilMissing('#leasing_table_processing')
                ->assertPresent('button.btn-delete');
        });
    }

    public function test_click_button_add_leasing_and_then_modal_present()
    {
        $this->user->givePermissions(['leasing_read', 'leasing_create']);
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user->getKey())
                ->visitRoute('masters.leasings.index')
                ->click('button[data-bs-target="#create-leasing"]')
                ->waitFor('#create-leasing')
                ->assertSee('Tambah Leasing');
        });
    }

    public function test_adding_data_via_modal()
    {
        $this->user->givePermissions(['leasing_read', 'leasing_create']);
        $this->browse(function (Browser $browser) {
            $leasing = Leasing::factory()->make();
            $browser->loginAs($this->user->getKey())
                ->visitRoute('masters.leasings.index')
                ->click('button[data-bs-target="#create-leasing"]')
                ->waitFor('#create-leasing')
                ->assertSee('Tambah Leasing')
                ->type('input[name="name"]', $leasing->name)
                ->press('button#create-leasing_submit')
                ->waitUntilMissing('#create-leasing_submit.indicator-progress')
                ->waitForText('successfully')
                ->click('button.swal2-confirm')
                ->waitFor('table#leasing_table')
                ->waitUntilMissing('#leasing_table_processing')
                ->type('input[data-kt-leasing-table-filter="search"]', $leasing->name)
                ->keys('input[data-kt-leasing-table-filter="search"]', '{enter}')
                ->waitUntilMissing('#leasing_table_processing')
                ->assertSee($leasing->name);
        });
    }

    public function test_edit_data_via_modal()
    {
        $this->user->givePermissions(['leasing_read', 'leasing_update']);
        $this->browse(function (Browser $browser) {
            $leasing = Leasing::factory()->create();
            $newLeasing = Leasing::factory()->make();
            $browser->loginAs($this->user->getKey())
                ->visitRoute('masters.leasings.index')
                ->waitUntilMissing('#leasing_table_processing')
                ->type('input[data-kt-leasing-table-filter="search"]', $leasing->name)
                ->keys('input[data-kt-leasing-table-filter="search"]', '{enter}')
                ->waitUntilMissing('#leasing_table_processing')
                ->click('button.btn-edit[data-leasing="' . $leasing->getKey() . '"]')
                ->waitFor('#create-leasing')
                ->assertSee('Edit Leasing')
                ->type('input[name="name"]', $leasing->name)
                ->press('button#create-leasing_submit')
                ->waitUntilMissing('#create-leasing_submit.indicator-progress')
                ->waitFor('.swal2-container')
                ->click('button.swal2-confirm')
                ->waitFor('table#leasing_table')
                ->click('#create-leasing_close')
                ->click('button.swal2-confirm')
                ->waitUntilMissing('#leasing_table_processing')
                ->type('input[data-kt-leasing-table-filter="search"]', $newLeasing->name)
                ->keys('input[data-kt-leasing-table-filter="search"]', '{enter}')
                ->waitUntilMissing('#leasing_table_processing');
        });
    }

    public function test_delete_data()
    {
        $this->user->givePermissions(['leasing_read', 'leasing_delete']);
        $this->browse(function (Browser $browser) {
            $leasing = Leasing::factory()->create();
            $browser->loginAs($this->user->getKey())
                ->visitRoute('masters.leasings.index')
                ->waitUntilMissing('#leasing_table_processing')
                ->type('input[data-kt-leasing-table-filter="search"]', $leasing->name)
                ->keys('input[data-kt-leasing-table-filter="search"]', '{enter}')
                ->waitUntilMissing('#leasing_table_processing')
                ->click('button.btn-delete[data-leasing="' . $leasing->getKey() . '"]')
                ->waitFor('div.swal2-popup.swal2-icon-warning')
                ->click('button.swal2-confirm')
                ->waitFor('div.swal2-popup.swal2-icon-success')
                ->click('button.swal2-confirm')
                ->waitUntilMissing('#leasing_table_processing')
                ->type('input[data-kt-leasing-table-filter="search"]', $leasing->name)
                ->keys('input[data-kt-leasing-table-filter="search"]', '{enter}')
                ->waitUntilMissing('#leasing_table_processing')
                ->assertSee('No matching records found');
        });
    }
}
