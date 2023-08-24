<?php

namespace Tests\Browser\Masters;

use App\Models\Masters\Category;
use App\Models\Masters\Cluster;
use App\Models\User;
use Database\Seeders\SidebarWithPermissionSeeder;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ClusterTest extends DuskTestCase
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
                ->visitRoute('masters.clusters.index')
                ->assertTitle('Dilarang')
                ->assertSee('403');
        });
    }

    public function test_can_access_index()
    {
        $this->user->givePermission('cluster_read');
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user->getKey())
                ->visitRoute('masters.clusters.index')
                ->assertTitle('Cluster')
                ->assertSee('Data Cluster');
        });
    }

    public function test_can_access_index_but_dosnt_have_permission_create()
    {
        $this->user->givePermission('cluster_read');
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user->getKey())
                ->visitRoute('masters.clusters.index')
                ->assertTitle('Cluster')
                ->assertSee('Data Cluster')
                ->assertNotPresent('button[data-bs-target="#create-cluster"]');
        });
    }

    public function test_can_access_index_and_have_permission_create()
    {
        $this->user->givePermissions(['cluster_read', 'cluster_create']);
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user->getKey())
                ->visitRoute('masters.clusters.index')
                ->assertTitle('Cluster')
                ->assertSee('Data Cluster')
                ->assertPresent('button[data-bs-target="#create-cluster"]');
        });
    }

    public function test_can_access_index_but_dosnt_have_permission_edit()
    {
        $this->user->givePermission('cluster_read');
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user->getKey())
                ->visitRoute('masters.clusters.index')
                ->assertTitle('Cluster')
                ->assertSee('Data Cluster')
                ->waitUntilMissing('#cluster_table_processing')
                ->assertNotPresent('button.btn-edit');
        });
    }

    public function test_can_access_index_and_have_permission_edit()
    {
        $this->user->givePermissions(['cluster_read', 'cluster_update']);
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user->getKey())
                ->visitRoute('masters.clusters.index')
                ->assertTitle('Cluster')
                ->assertSee('Data Cluster')
                ->waitUntilMissing('#cluster_table_processing')
                ->assertPresent('button.btn-edit');
        });
    }

    public function test_can_access_index_but_dosnt_have_permission_delete()
    {
        $this->user->givePermission('cluster_read');
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user->getKey())
                ->visitRoute('masters.clusters.index')
                ->assertTitle('Cluster')
                ->assertSee('Data Cluster')
                ->waitUntilMissing('#cluster_table_processing')
                ->assertNotPresent('button.btn-delete');
        });
    }

    public function test_can_access_index_and_have_permission_delete()
    {
        $this->user->givePermissions(['cluster_read', 'cluster_delete']);
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user->getKey())
                ->visitRoute('masters.clusters.index')
                ->assertTitle('Cluster')
                ->assertSee('Data Cluster')
                ->waitUntilMissing('#cluster_table_processing')
                ->assertPresent('button.btn-delete');
        });
    }

    public function test_click_button_add_cluster_and_then_modal_present()
    {
        $this->user->givePermissions(['cluster_read', 'cluster_create']);
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user->getKey())
                ->visitRoute('masters.clusters.index')
                ->click('button[data-bs-target="#create-cluster"]')
                ->waitFor('#create-cluster')
                ->assertSee('Tambah Cluster');
        });
    }

    public function test_adding_data_via_modal()
    {
        $category = Category::factory()->create();
        $this->user->givePermissions(['cluster_read', 'cluster_create']);
        $this->browse(function (Browser $browser) use ($category) {
            $cluster = fake()->sentence(1);
            $browser->loginAs($this->user->getKey())
                ->visitRoute('masters.clusters.index')
                ->click('button[data-bs-target="#create-cluster"]')
                ->waitFor('#create-cluster')
                ->assertSee('Tambah Cluster')
                ->click('span.select2.select2-container')
                ->waitFor('span.select2-dropdown')
                ->type('input.select2-search__field', $category->name)
                ->waitFor('.select2-results__options')
                ->click('.select2-results__option:first-child')
                ->assertSeeIn('span.select2-selection__rendered', $category->name)
                ->type('input[name="name"]', $cluster)
                ->press('button#create-cluster_submit')
                ->waitUntilMissing('#create-cluster_submit.indicator-progress')
                ->waitForText('successfully')
                ->click('button.swal2-confirm')
                ->waitFor('table#cluster_table')
                ->waitUntilMissing('#cluster_table_processing')
                ->type('input[data-kt-cluster-table-filter="search"]', $cluster)
                ->keys('input[data-kt-cluster-table-filter="search"]', '{enter}')
                ->waitUntilMissing('#cluster_table_processing')
                ->assertSee($cluster);
        });
    }

    public function test_edit_data_via_modal()
    {
        $category = Category::factory()->create();
        $cluster = Cluster::factory()->create();
        $this->user->givePermissions(['cluster_read', 'cluster_update']);
        $this->browse(function (Browser $browser) use ($cluster, $category) {
            $newCluster = fake()->sentence(1);
            $browser->loginAs($this->user->getKey())
                ->visitRoute('masters.clusters.index')
                ->waitUntilMissing('#cluster_table_processing')
                ->type('input[data-kt-cluster-table-filter="search"]', $cluster->name)
                ->keys('input[data-kt-cluster-table-filter="search"]', '{enter}')
                ->waitUntilMissing('#cluster_table_processing')
                ->click('button.btn-edit[data-cluster="' . $cluster->getKey() . '"]')
                ->waitFor('#create-cluster')
                ->assertSee('Edit Cluster')
                ->click('span.select2.select2-container')
                ->waitFor('span.select2-dropdown')
                ->type('input.select2-search__field', $category->name)
                ->waitFor('.select2-results__options')
                ->click('.select2-results__option:first-child')
                ->assertSeeIn('span.select2-selection__rendered', $category->name)
                ->type('input[name="name"]', $cluster)
                ->press('button#create-cluster_submit')
                ->waitUntilMissing('#create-cluster_submit.indicator-progress')
                ->waitFor('.swal2-container')
                ->click('button.swal2-confirm')
                ->waitFor('table#cluster_table')
                ->click('#create-cluster_close')
                ->click('button.swal2-confirm')
                ->waitUntilMissing('#cluster_table_processing')
                ->type('input[data-kt-cluster-table-filter="search"]', $newCluster)
                ->keys('input[data-kt-cluster-table-filter="search"]', '{enter}')
                ->waitUntilMissing('#cluster_table_processing');
        });
    }

    public function test_delete_data()
    {
        $cluster = Cluster::factory()->create();
        $this->user->givePermissions(['cluster_read', 'cluster_delete']);
        $this->browse(function (Browser $browser) use ($cluster) {
            $browser->loginAs($this->user->getKey())
                ->visitRoute('masters.clusters.index')
                ->waitUntilMissing('#cluster_table_processing')
                ->type('input[data-kt-cluster-table-filter="search"]', $cluster->name)
                ->keys('input[data-kt-cluster-table-filter="search"]', '{enter}')
                ->waitUntilMissing('#cluster_table_processing')
                ->click('button.btn-delete[data-cluster="' . $cluster->getKey() . '"]')
                ->waitFor('div.swal2-popup.swal2-icon-warning')
                ->click('button.swal2-confirm')
                ->waitFor('div.swal2-popup.swal2-icon-success')
                ->click('button.swal2-confirm')
                ->waitUntilMissing('#cluster_table_processing')
                ->type('input[data-kt-cluster-table-filter="search"]', $cluster->name)
                ->keys('input[data-kt-cluster-table-filter="search"]', '{enter}')
                ->waitUntilMissing('#cluster_table_processing')
                ->assertSee('No matching records found');
        });
    }
}
