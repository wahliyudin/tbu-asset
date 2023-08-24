<?php

namespace Tests\Browser\Masters;

use App\Models\Masters\SubCluster;
use App\Models\Masters\SubClusterItem;
use App\Models\User;
use Database\Seeders\SidebarWithPermissionSeeder;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class SubClusterItemTest extends DuskTestCase
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
                ->visitRoute('masters.sub-cluster-items.index')
                ->assertTitle('Dilarang')
                ->assertSee('403');
        });
    }

    public function test_can_access_index()
    {
        $this->user->givePermission('sub_cluster_item_read');
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user->getKey())
                ->visitRoute('masters.sub-cluster-items.index')
                ->assertTitle('Sub Cluster Item')
                ->assertSee('Data Sub Cluster Item');
        });
    }

    public function test_can_access_index_but_dosnt_have_permission_create()
    {
        $this->user->givePermission('sub_cluster_item_read');
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user->getKey())
                ->visitRoute('masters.sub-cluster-items.index')
                ->assertTitle('Sub Cluster Item')
                ->assertSee('Data Sub Cluster Item')
                ->assertNotPresent('button[data-bs-target="#create-sub-cluster-item"]');
        });
    }

    public function test_can_access_index_and_have_permission_create()
    {
        $this->user->givePermissions(['sub_cluster_item_read', 'sub_cluster_item_create']);
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user->getKey())
                ->visitRoute('masters.sub-cluster-items.index')
                ->assertTitle('Sub Cluster Item')
                ->assertSee('Data Sub Cluster Item')
                ->assertPresent('button[data-bs-target="#create-sub-cluster-item"]');
        });
    }

    public function test_can_access_index_but_dosnt_have_permission_edit()
    {
        $this->user->givePermission('sub_cluster_item_read');
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user->getKey())
                ->visitRoute('masters.sub-cluster-items.index')
                ->assertTitle('Sub Cluster Item')
                ->assertSee('Data Sub Cluster Item')
                ->waitUntilMissing('#sub-cluster-item_table_processing')
                ->assertNotPresent('button.btn-edit');
        });
    }

    public function test_can_access_index_and_have_permission_edit()
    {
        $this->user->givePermissions(['sub_cluster_item_read', 'sub_cluster_item_update']);
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user->getKey())
                ->visitRoute('masters.sub-cluster-items.index')
                ->assertTitle('Sub Cluster Item')
                ->assertSee('Data Sub Cluster Item')
                ->waitUntilMissing('#sub-cluster-item_table_processing')
                ->assertPresent('button.btn-edit');
        });
    }

    public function test_can_access_index_but_dosnt_have_permission_delete()
    {
        $this->user->givePermission('sub_cluster_item_read');
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user->getKey())
                ->visitRoute('masters.sub-cluster-items.index')
                ->assertTitle('Sub Cluster Item')
                ->assertSee('Data Sub Cluster Item')
                ->waitUntilMissing('#sub-cluster-item_table_processing')
                ->assertNotPresent('button.btn-delete');
        });
    }

    public function test_can_access_index_and_have_permission_delete()
    {
        $this->user->givePermissions(['sub_cluster_item_read', 'sub_cluster_item_delete']);
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user->getKey())
                ->visitRoute('masters.sub-cluster-items.index')
                ->assertTitle('Sub Cluster Item')
                ->assertSee('Data Sub Cluster Item')
                ->waitUntilMissing('#sub-cluster-item_table_processing')
                ->assertPresent('button.btn-delete');
        });
    }

    public function test_click_button_add_sub_cluster_item_and_then_modal_present()
    {
        $this->user->givePermissions(['sub_cluster_item_read', 'sub_cluster_item_create']);
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user->getKey())
                ->visitRoute('masters.sub-cluster-items.index')
                ->click('button[data-bs-target="#create-sub-cluster-item"]')
                ->waitFor('#create-sub-cluster-item')
                ->assertSee('Tambah Sub Cluster Item');
        });
    }

    public function test_adding_data_via_modal()
    {
        $subCluster = SubCluster::factory()->create();
        $this->user->givePermissions(['sub_cluster_item_read', 'sub_cluster_item_create']);
        $this->browse(function (Browser $browser) use ($subCluster) {
            $subClusterItem = fake()->sentence(1);
            $browser->loginAs($this->user->getKey())
                ->visitRoute('masters.sub-cluster-items.index')
                ->click('button[data-bs-target="#create-sub-cluster-item"]')
                ->waitFor('#create-sub-cluster-item')
                ->assertSee('Tambah Sub Cluster Item')
                ->click('span.select2.select2-container')
                ->waitFor('span.select2-dropdown')
                ->type('input.select2-search__field', $subCluster->name)
                ->waitFor('.select2-results__options')
                ->click('.select2-results__option:first-child')
                ->assertSeeIn('span.select2-selection__rendered', $subCluster->name)
                ->type('input[name="name"]', $subClusterItem)
                ->press('button#create-sub-cluster-item_submit')
                ->waitUntilMissing('#create-sub-cluster-item_submit.indicator-progress')
                ->waitForText('successfully')
                ->click('button.swal2-confirm')
                ->waitFor('table#sub-cluster-item_table')
                ->waitUntilMissing('#sub-cluster-item_table_processing')
                ->type('input[data-kt-sub-cluster-item-table-filter="search"]', $subClusterItem)
                ->keys('input[data-kt-sub-cluster-item-table-filter="search"]', '{enter}')
                ->waitUntilMissing('#sub-cluster-item_table_processing')
                ->assertSee($subClusterItem);
        });
    }

    public function test_edit_data_via_modal()
    {
        $subCluster = SubCluster::factory()->create();
        $subClusterItem = SubClusterItem::factory()->create();
        $this->user->givePermissions(['sub_cluster_item_read', 'sub_cluster_item_update']);
        $this->browse(function (Browser $browser) use ($subClusterItem, $subCluster) {
            $newSubClusterItem = fake()->sentence(1);
            $browser->loginAs($this->user->getKey())
                ->visitRoute('masters.sub-cluster-items.index')
                ->waitUntilMissing('#sub-cluster-item_table_processing')
                ->type('input[data-kt-sub-cluster-item-table-filter="search"]', $subClusterItem->name)
                ->keys('input[data-kt-sub-cluster-item-table-filter="search"]', '{enter}')
                ->waitUntilMissing('#sub-cluster-item_table_processing')
                ->click('button.btn-edit[data-sub-cluster-item="' . $subClusterItem->getKey() . '"]')
                ->waitFor('#create-sub-cluster-item')
                ->assertSee('Edit Sub Cluster Item')
                ->click('span.select2.select2-container')
                ->waitFor('span.select2-dropdown')
                ->type('input.select2-search__field', $subCluster->name)
                ->waitFor('.select2-results__options')
                ->click('.select2-results__option:first-child')
                ->assertSeeIn('span.select2-selection__rendered', $subCluster->name)
                ->type('input[name="name"]', $subClusterItem)
                ->press('button#create-sub-cluster-item_submit')
                ->waitUntilMissing('#create-sub-cluster-item_submit.indicator-progress')
                ->waitFor('.swal2-container')
                ->click('button.swal2-confirm')
                ->waitFor('table#sub-cluster-item_table')
                ->click('#create-sub-cluster-item_close')
                ->click('button.swal2-confirm')
                ->waitUntilMissing('#sub-cluster-item_table_processing')
                ->type('input[data-kt-sub-cluster-item-table-filter="search"]', $newSubClusterItem)
                ->keys('input[data-kt-sub-cluster-item-table-filter="search"]', '{enter}')
                ->waitUntilMissing('#sub-cluster-item_table_processing');
        });
    }

    public function test_delete_data()
    {
        $subClusterItem = SubClusterItem::factory()->create();
        $this->user->givePermissions(['sub_cluster_item_read', 'sub_cluster_item_delete']);
        $this->browse(function (Browser $browser) use ($subClusterItem) {
            $browser->loginAs($this->user->getKey())
                ->visitRoute('masters.sub-cluster-items.index')
                ->waitUntilMissing('#sub-cluster-item_table_processing')
                ->type('input[data-kt-sub-cluster-item-table-filter="search"]', $subClusterItem->name)
                ->keys('input[data-kt-sub-cluster-item-table-filter="search"]', '{enter}')
                ->waitUntilMissing('#sub-cluster-item_table_processing')
                ->click('button.btn-delete[data-sub-cluster-item="' . $subClusterItem->getKey() . '"]')
                ->waitFor('div.swal2-popup.swal2-icon-warning')
                ->click('button.swal2-confirm')
                ->waitFor('div.swal2-popup.swal2-icon-success')
                ->click('button.swal2-confirm')
                ->waitUntilMissing('#sub-cluster-item_table_processing')
                ->type('input[data-kt-sub-cluster-item-table-filter="search"]', $subClusterItem->name)
                ->keys('input[data-kt-sub-cluster-item-table-filter="search"]', '{enter}')
                ->waitUntilMissing('#sub-cluster-item_table_processing')
                ->assertSee('No matching records found');
        });
    }
}
