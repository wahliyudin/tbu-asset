<?php

namespace Tests\Browser\Masters;

use App\Models\Masters\Dealer;
use App\Models\User;
use Database\Seeders\SidebarWithPermissionSeeder;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class DealerTest extends DuskTestCase
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
                ->visitRoute('masters.dealers.index')
                ->assertTitle('Dilarang')
                ->assertSee('403');
        });
    }

    public function test_can_access_index()
    {
        $this->user->givePermission('dealer_read');
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user->getKey())
                ->visitRoute('masters.dealers.index')
                ->assertTitle('Dealer')
                ->assertSee('Data Dealer');
        });
    }

    public function test_can_access_index_but_dosnt_have_permission_create()
    {
        $this->user->givePermission('dealer_read');
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user->getKey())
                ->visitRoute('masters.dealers.index')
                ->assertTitle('Dealer')
                ->assertSee('Data Dealer')
                ->assertNotPresent('button[data-bs-target="#create-dealer"]');
        });
    }

    public function test_can_access_index_and_have_permission_create()
    {
        $this->user->givePermissions(['dealer_read', 'dealer_create']);
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user->getKey())
                ->visitRoute('masters.dealers.index')
                ->assertTitle('Dealer')
                ->assertSee('Data Dealer')
                ->assertPresent('button[data-bs-target="#create-dealer"]');
        });
    }

    public function test_can_access_index_but_dosnt_have_permission_edit()
    {
        $this->user->givePermission('dealer_read');
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user->getKey())
                ->visitRoute('masters.dealers.index')
                ->assertTitle('Dealer')
                ->assertSee('Data Dealer')
                ->waitUntilMissing('#dealer_table_processing')
                ->assertNotPresent('button.btn-edit');
        });
    }

    public function test_can_access_index_and_have_permission_edit()
    {
        $this->user->givePermissions(['dealer_read', 'dealer_update']);
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user->getKey())
                ->visitRoute('masters.dealers.index')
                ->assertTitle('Dealer')
                ->assertSee('Data Dealer')
                ->waitUntilMissing('#dealer_table_processing')
                ->assertPresent('button.btn-edit');
        });
    }

    public function test_can_access_index_but_dosnt_have_permission_delete()
    {
        $this->user->givePermission('dealer_read');
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user->getKey())
                ->visitRoute('masters.dealers.index')
                ->assertTitle('Dealer')
                ->assertSee('Data Dealer')
                ->waitUntilMissing('#dealer_table_processing')
                ->assertNotPresent('button.btn-delete');
        });
    }

    public function test_can_access_index_and_have_permission_delete()
    {
        $this->user->givePermissions(['dealer_read', 'dealer_delete']);
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user->getKey())
                ->visitRoute('masters.dealers.index')
                ->assertTitle('Dealer')
                ->assertSee('Data Dealer')
                ->waitUntilMissing('#dealer_table_processing')
                ->assertPresent('button.btn-delete');
        });
    }

    public function test_click_button_add_dealer_and_then_modal_present()
    {
        $this->user->givePermissions(['dealer_read', 'dealer_create']);
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user->getKey())
                ->visitRoute('masters.dealers.index')
                ->click('button[data-bs-target="#create-dealer"]')
                ->waitFor('#create-dealer')
                ->assertSee('Tambah Dealer');
        });
    }

    public function test_adding_data_via_modal()
    {
        $this->user->givePermissions(['dealer_read', 'dealer_create']);
        $this->browse(function (Browser $browser) {
            $dealer = Dealer::factory()->make();
            $browser->loginAs($this->user->getKey())
                ->visitRoute('masters.dealers.index')
                ->click('button[data-bs-target="#create-dealer"]')
                ->waitFor('#create-dealer')
                ->assertSee('Tambah Dealer')
                ->type('input[name="name"]', $dealer->name)
                ->press('button#create-dealer_submit')
                ->waitUntilMissing('#create-dealer_submit.indicator-progress')
                ->waitForText('successfully')
                ->click('button.swal2-confirm')
                ->waitFor('table#dealer_table')
                ->waitUntilMissing('#dealer_table_processing')
                ->type('input[data-kt-dealer-table-filter="search"]', $dealer->name)
                ->keys('input[data-kt-dealer-table-filter="search"]', '{enter}')
                ->waitUntilMissing('#dealer_table_processing')
                ->assertSee($dealer->name);
        });
    }

    public function test_edit_data_via_modal()
    {
        $this->user->givePermissions(['dealer_read', 'dealer_update']);
        $this->browse(function (Browser $browser) {
            $dealer = Dealer::factory()->create();
            $newDealer = Dealer::factory()->make();
            $browser->loginAs($this->user->getKey())
                ->visitRoute('masters.dealers.index')
                ->waitUntilMissing('#dealer_table_processing')
                ->type('input[data-kt-dealer-table-filter="search"]', $dealer->name)
                ->keys('input[data-kt-dealer-table-filter="search"]', '{enter}')
                ->waitUntilMissing('#dealer_table_processing')
                ->click('button.btn-edit[data-dealer="' . $dealer->getKey() . '"]')
                ->waitFor('#create-dealer')
                ->assertSee('Edit Dealer')
                ->type('input[name="name"]', $dealer->name)
                ->press('button#create-dealer_submit')
                ->waitUntilMissing('#create-dealer_submit.indicator-progress')
                ->waitFor('.swal2-container')
                ->click('button.swal2-confirm')
                ->waitFor('table#dealer_table')
                ->click('#create-dealer_close')
                ->click('button.swal2-confirm')
                ->waitUntilMissing('#dealer_table_processing')
                ->type('input[data-kt-dealer-table-filter="search"]', $newDealer->name)
                ->keys('input[data-kt-dealer-table-filter="search"]', '{enter}')
                ->waitUntilMissing('#dealer_table_processing');
        });
    }

    public function test_delete_data()
    {
        $this->user->givePermissions(['dealer_read', 'dealer_delete']);
        $this->browse(function (Browser $browser) {
            $dealer = Dealer::factory()->create();
            $browser->loginAs($this->user->getKey())
                ->visitRoute('masters.dealers.index')
                ->waitUntilMissing('#dealer_table_processing')
                ->type('input[data-kt-dealer-table-filter="search"]', $dealer->name)
                ->keys('input[data-kt-dealer-table-filter="search"]', '{enter}')
                ->waitUntilMissing('#dealer_table_processing')
                ->click('button.btn-delete[data-dealer="' . $dealer->getKey() . '"]')
                ->waitFor('div.swal2-popup.swal2-icon-warning')
                ->click('button.swal2-confirm')
                ->waitFor('div.swal2-popup.swal2-icon-success')
                ->click('button.swal2-confirm')
                ->waitUntilMissing('#dealer_table_processing')
                ->type('input[data-kt-dealer-table-filter="search"]', $dealer->name)
                ->keys('input[data-kt-dealer-table-filter="search"]', '{enter}')
                ->waitUntilMissing('#dealer_table_processing')
                ->assertSee('No matching records found');
        });
    }
}
