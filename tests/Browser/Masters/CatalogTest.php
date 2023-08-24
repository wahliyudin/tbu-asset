<?php

namespace Tests\Browser\Masters;

use App\Models\Masters\Catalog;
use App\Models\User;
use Database\Seeders\SidebarWithPermissionSeeder;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class CatalogTest extends DuskTestCase
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
                ->visitRoute('masters.catalogs.index')
                ->assertTitle('Dilarang')
                ->assertSee('403');
        });
    }

    public function test_can_access_index()
    {
        $this->user->givePermission('catalog_read');
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user->getKey())
                ->visitRoute('masters.catalogs.index')
                ->assertTitle('Catalog')
                ->assertSee('Data Catalog');
        });
    }

    public function test_can_access_index_but_dosnt_have_permission_create()
    {
        $this->user->givePermission('catalog_read');
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user->getKey())
                ->visitRoute('masters.catalogs.index')
                ->assertTitle('Catalog')
                ->assertSee('Data Catalog')
                ->assertNotPresent('button[data-bs-target="#create-catalog"]');
        });
    }

    public function test_can_access_index_and_have_permission_create()
    {
        $this->user->givePermissions(['catalog_read', 'catalog_create']);
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user->getKey())
                ->visitRoute('masters.catalogs.index')
                ->assertTitle('Catalog')
                ->assertSee('Data Catalog')
                ->assertPresent('button[data-bs-target="#create-catalog"]');
        });
    }

    public function test_can_access_index_but_dosnt_have_permission_edit()
    {
        $this->user->givePermission('catalog_read');
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user->getKey())
                ->visitRoute('masters.catalogs.index')
                ->assertTitle('Catalog')
                ->assertSee('Data Catalog')
                ->waitUntilMissing('#catalog_table_processing')
                ->assertNotPresent('button.btn-edit');
        });
    }

    public function test_can_access_index_and_have_permission_edit()
    {
        $this->user->givePermissions(['catalog_read', 'catalog_update']);
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user->getKey())
                ->visitRoute('masters.catalogs.index')
                ->assertTitle('Catalog')
                ->assertSee('Data Catalog')
                ->waitUntilMissing('#catalog_table_processing')
                ->assertPresent('button.btn-edit');
        });
    }

    public function test_can_access_index_but_dosnt_have_permission_delete()
    {
        $this->user->givePermission('catalog_read');
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user->getKey())
                ->visitRoute('masters.catalogs.index')
                ->assertTitle('Catalog')
                ->assertSee('Data Catalog')
                ->waitUntilMissing('#catalog_table_processing')
                ->assertNotPresent('button.btn-delete');
        });
    }

    public function test_can_access_index_and_have_permission_delete()
    {
        $this->user->givePermissions(['catalog_read', 'catalog_delete']);
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user->getKey())
                ->visitRoute('masters.catalogs.index')
                ->assertTitle('Catalog')
                ->assertSee('Data Catalog')
                ->waitUntilMissing('#catalog_table_processing')
                ->assertPresent('button.btn-delete');
        });
    }

    public function test_click_button_add_catalog_and_then_modal_present()
    {
        $this->user->givePermissions(['catalog_read', 'catalog_create']);
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user->getKey())
                ->visitRoute('masters.catalogs.index')
                ->click('button[data-bs-target="#create-catalog"]')
                ->waitFor('#create-catalog')
                ->assertSee('Tambah Catalog');
        });
    }

    public function test_adding_data_via_modal()
    {
        $this->user->givePermissions(['catalog_read', 'catalog_create']);
        $this->browse(function (Browser $browser) {
            $catalog = Catalog::factory()->make();
            $browser->loginAs($this->user->getKey())
                ->visitRoute('masters.catalogs.index')
                ->click('button[data-bs-target="#create-catalog"]')
                ->waitFor('#create-catalog')
                ->assertSee('Tambah Catalog')
                ->type('input[name="unit_model"]', $catalog->unit_model)
                ->type('input[name="unit_type"]', $catalog->unit_type)
                ->type('input[name="seri"]', $catalog->seri)
                ->type('input[name="unit_class"]', $catalog->unit_class)
                ->type('input[name="brand"]', $catalog->brand)
                ->type('input[name="spesification"]', $catalog->spesification)
                ->press('button#create-catalog_submit')
                ->waitUntilMissing('#create-catalog_submit.indicator-progress')
                ->waitForText('successfully')
                ->click('button.swal2-confirm')
                ->waitFor('table#catalog_table')
                ->waitUntilMissing('#catalog_table_processing')
                ->type('input[data-kt-catalog-table-filter="search"]', $catalog->unit_model)
                ->keys('input[data-kt-catalog-table-filter="search"]', '{enter}')
                ->waitUntilMissing('#catalog_table_processing')
                ->assertSee($catalog->unit_model);
        });
    }

    public function test_edit_data_via_modal()
    {
        $this->user->givePermissions(['catalog_read', 'catalog_update']);
        $this->browse(function (Browser $browser) {
            $catalog = Catalog::factory()->create();
            $newCatalog = Catalog::factory()->make();
            $browser->loginAs($this->user->getKey())
                ->visitRoute('masters.catalogs.index')
                ->waitUntilMissing('#catalog_table_processing')
                ->type('input[data-kt-catalog-table-filter="search"]', $catalog->name)
                ->keys('input[data-kt-catalog-table-filter="search"]', '{enter}')
                ->waitUntilMissing('#catalog_table_processing')
                ->click('button.btn-edit[data-catalog="' . $catalog->getKey() . '"]')
                ->waitFor('#create-catalog')
                ->assertSee('Edit Catalog')
                ->type('input[name="unit_model"]', $newCatalog->unit_model)
                ->type('input[name="unit_type"]', $newCatalog->unit_type)
                ->type('input[name="seri"]', $newCatalog->seri)
                ->type('input[name="unit_class"]', $newCatalog->unit_class)
                ->type('input[name="brand"]', $newCatalog->brand)
                ->type('input[name="spesification"]', $newCatalog->spesification)
                ->press('button#create-catalog_submit')
                ->waitUntilMissing('#create-catalog_submit.indicator-progress')
                ->waitFor('.swal2-container')
                ->click('button.swal2-confirm')
                ->waitFor('table#catalog_table')
                ->click('#create-catalog_close')
                ->click('button.swal2-confirm')
                ->waitUntilMissing('#catalog_table_processing')
                ->type('input[data-kt-catalog-table-filter="search"]', $newCatalog->unit_model)
                ->keys('input[data-kt-catalog-table-filter="search"]', '{enter}')
                ->waitUntilMissing('#catalog_table_processing');
        });
    }

    public function test_delete_data()
    {
        $this->user->givePermissions(['catalog_read', 'catalog_delete']);
        $this->browse(function (Browser $browser) {
            $catalog = Catalog::factory()->create();
            $browser->loginAs($this->user->getKey())
                ->visitRoute('masters.catalogs.index')
                ->waitUntilMissing('#catalog_table_processing')
                ->type('input[data-kt-catalog-table-filter="search"]', $catalog->unit_model)
                ->keys('input[data-kt-catalog-table-filter="search"]', '{enter}')
                ->waitUntilMissing('#catalog_table_processing')
                ->click('button.btn-delete[data-catalog="' . $catalog->getKey() . '"]')
                ->waitFor('div.swal2-popup.swal2-icon-warning')
                ->click('button.swal2-confirm')
                ->waitFor('div.swal2-popup.swal2-icon-success')
                ->click('button.swal2-confirm')
                ->waitUntilMissing('#catalog_table_processing')
                ->type('input[data-kt-catalog-table-filter="search"]', $catalog->unit_model)
                ->keys('input[data-kt-catalog-table-filter="search"]', '{enter}')
                ->waitUntilMissing('#catalog_table_processing')
                ->assertSee('No matching records found');
        });
    }
}
