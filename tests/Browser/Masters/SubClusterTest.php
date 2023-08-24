<?php

namespace Tests\Browser\Masters;

use App\Models\Masters\Cluster;
use App\Models\Masters\SubCluster;
use App\Models\User;
use Database\Seeders\SidebarWithPermissionSeeder;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class SubSubClusterTest extends DuskTestCase
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
                ->visitRoute('masters.sub-clusters.index')
                ->assertTitle('Dilarang')
                ->assertSee('403');
        });
    }

    public function test_can_access_index()
    {
        $this->user->givePermission('sub_cluster_read');
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user->getKey())
                ->visitRoute('masters.sub-clusters.index')
                ->assertTitle('Sub Cluster')
                ->assertSee('Data Sub Cluster');
        });
    }

    public function test_can_access_index_but_dosnt_have_permission_create()
    {
        $this->user->givePermission('sub_cluster_read');
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user->getKey())
                ->visitRoute('masters.sub-clusters.index')
                ->assertTitle('Sub Cluster')
                ->assertSee('Data Sub Cluster')
                ->assertNotPresent('button[data-bs-target="#create-sub-cluster"]');
        });
    }

    public function test_can_access_index_and_have_permission_create()
    {
        $this->user->givePermissions(['sub_cluster_read', 'sub_cluster_create']);
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user->getKey())
                ->visitRoute('masters.sub-clusters.index')
                ->assertTitle('Sub Cluster')
                ->assertSee('Data Sub Cluster')
                ->assertPresent('button[data-bs-target="#create-sub-cluster"]');
        });
    }

    public function test_can_access_index_but_dosnt_have_permission_edit()
    {
        $this->user->givePermission('sub_cluster_read');
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user->getKey())
                ->visitRoute('masters.sub-clusters.index')
                ->assertTitle('Sub Cluster')
                ->assertSee('Data Sub Cluster')
                ->waitUntilMissing('#sub-cluster_table_processing')
                ->assertNotPresent('button.btn-edit');
        });
    }

    public function test_can_access_index_and_have_permission_edit()
    {
        $this->user->givePermissions(['sub_cluster_read', 'sub_cluster_update']);
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user->getKey())
                ->visitRoute('masters.sub-clusters.index')
                ->assertTitle('Sub Cluster')
                ->assertSee('Data Sub Cluster')
                ->waitUntilMissing('#sub-cluster_table_processing')
                ->assertPresent('button.btn-edit');
        });
    }

    public function test_can_access_index_but_dosnt_have_permission_delete()
    {
        $this->user->givePermission('sub_cluster_read');
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user->getKey())
                ->visitRoute('masters.sub-clusters.index')
                ->assertTitle('Sub Cluster')
                ->assertSee('Data Sub Cluster')
                ->waitUntilMissing('#sub-cluster_table_processing')
                ->assertNotPresent('button.btn-delete');
        });
    }

    public function test_can_access_index_and_have_permission_delete()
    {
        $this->user->givePermissions(['sub_cluster_read', 'sub_cluster_delete']);
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user->getKey())
                ->visitRoute('masters.sub-clusters.index')
                ->assertTitle('Sub Cluster')
                ->assertSee('Data Sub Cluster')
                ->waitUntilMissing('#sub-cluster_table_processing')
                ->assertPresent('button.btn-delete');
        });
    }

    public function test_click_button_add_sub_cluster_and_then_modal_present()
    {
        $this->user->givePermissions(['sub_cluster_read', 'sub_cluster_create']);
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user->getKey())
                ->visitRoute('masters.sub-clusters.index')
                ->click('button[data-bs-target="#create-sub-cluster"]')
                ->waitFor('#create-sub-cluster')
                ->assertSee('Tambah Sub Cluster');
        });
    }

    public function test_adding_data_via_modal()
    {
        $cluster = Cluster::factory()->create();
        $this->user->givePermissions(['sub_cluster_read', 'sub_cluster_create']);
        $this->browse(function (Browser $browser) use ($cluster) {
            $subCluster = fake()->sentence(1);
            $browser->loginAs($this->user->getKey())
                ->visitRoute('masters.sub-clusters.index')
                ->click('button[data-bs-target="#create-sub-cluster"]')
                ->waitFor('#create-sub-cluster')
                ->assertSee('Tambah Sub Cluster')
                ->click('span.select2.select2-container')
                ->waitFor('span.select2-dropdown')
                ->type('input.select2-search__field', $cluster->name)
                ->waitFor('.select2-results__options')
                ->click('.select2-results__option:first-child')
                ->assertSeeIn('span.select2-selection__rendered', $cluster->name)
                ->type('input[name="name"]', $subCluster)
                ->press('button#create-sub-cluster_submit')
                ->waitUntilMissing('#create-sub-cluster_submit.indicator-progress')
                ->waitForText('successfully')
                ->click('button.swal2-confirm')
                ->waitFor('table#sub-cluster_table')
                ->waitUntilMissing('#sub-cluster_table_processing')
                ->type('input[data-kt-sub-cluster-table-filter="search"]', $subCluster)
                ->keys('input[data-kt-sub-cluster-table-filter="search"]', '{enter}')
                ->waitUntilMissing('#sub-cluster_table_processing')
                ->assertSee($subCluster);
        });
    }

    public function test_edit_data_via_modal()
    {
        $cluster = Cluster::factory()->create();
        $subCluster = SubCluster::factory()->create();
        $this->user->givePermissions(['sub_cluster_read', 'sub_cluster_update']);
        $this->browse(function (Browser $browser) use ($subCluster, $cluster) {
            $newSubCluster = fake()->sentence(1);
            $browser->loginAs($this->user->getKey())
                ->visitRoute('masters.sub-clusters.index')
                ->waitUntilMissing('#sub-cluster_table_processing')
                ->type('input[data-kt-sub-cluster-table-filter="search"]', $subCluster->name)
                ->keys('input[data-kt-sub-cluster-table-filter="search"]', '{enter}')
                ->waitUntilMissing('#sub-cluster_table_processing')
                ->click('button.btn-edit[data-sub-cluster="' . $subCluster->getKey() . '"]')
                ->waitFor('#create-sub-cluster')
                ->assertSee('Edit Sub Cluster')
                ->click('span.select2.select2-container')
                ->waitFor('span.select2-dropdown')
                ->type('input.select2-search__field', $cluster->name)
                ->waitFor('.select2-results__options')
                ->click('.select2-results__option:first-child')
                ->assertSeeIn('span.select2-selection__rendered', $cluster->name)
                ->type('input[name="name"]', $subCluster)
                ->press('button#create-sub-cluster_submit')
                ->waitUntilMissing('#create-sub-cluster_submit.indicator-progress')
                ->waitFor('.swal2-container')
                ->click('button.swal2-confirm')
                ->waitFor('table#sub-cluster_table')
                ->click('#create-sub-cluster_close')
                ->click('button.swal2-confirm')
                ->waitUntilMissing('#sub-cluster_table_processing')
                ->type('input[data-kt-sub-cluster-table-filter="search"]', $newSubCluster)
                ->keys('input[data-kt-sub-cluster-table-filter="search"]', '{enter}')
                ->waitUntilMissing('#sub-cluster_table_processing');
        });
    }

    public function test_delete_data()
    {
        $subCluster = SubCluster::factory()->create();
        $this->user->givePermissions(['sub_cluster_read', 'sub_cluster_delete']);
        $this->browse(function (Browser $browser) use ($subCluster) {
            $browser->loginAs($this->user->getKey())
                ->visitRoute('masters.sub-clusters.index')
                ->waitUntilMissing('#sub-cluster_table_processing')
                ->type('input[data-kt-sub-cluster-table-filter="search"]', $subCluster->name)
                ->keys('input[data-kt-sub-cluster-table-filter="search"]', '{enter}')
                ->waitUntilMissing('#sub-cluster_table_processing')
                ->click('button.btn-delete[data-sub-cluster="' . $subCluster->getKey() . '"]')
                ->waitFor('div.swal2-popup.swal2-icon-warning')
                ->click('button.swal2-confirm')
                ->waitFor('div.swal2-popup.swal2-icon-success')
                ->click('button.swal2-confirm')
                ->waitUntilMissing('#sub-cluster_table_processing')
                ->type('input[data-kt-sub-cluster-table-filter="search"]', $subCluster->name)
                ->keys('input[data-kt-sub-cluster-table-filter="search"]', '{enter}')
                ->waitUntilMissing('#sub-cluster_table_processing')
                ->assertSee('No matching records found');
        });
    }
}
