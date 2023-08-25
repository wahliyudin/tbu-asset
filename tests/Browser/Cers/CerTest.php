<?php

namespace Tests\Browser\Cers;

use App\Models\Cers\Cer;
use App\Models\User;
use Database\Seeders\SidebarWithPermissionSeeder;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class CerTest extends DuskTestCase
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
                ->visitRoute('asset-requests.index')
                ->assertTitle('Dilarang')
                ->assertSee('403');
        });
    }

    public function test_can_access_index()
    {
        $this->user->syncPermissions(['asset_request_read']);
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user->getKey())
                ->visitRoute('asset-requests.index')
                ->assertTitle('Cer')
                ->assertSee('Data Cer');
        });
    }

    public function test_can_access_index_but_dosnt_have_permission_create()
    {
        $this->user->syncPermissions(['asset_request_read']);
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user->getKey())
                ->visitRoute('asset-requests.index')
                ->assertTitle('Cer')
                ->assertSee('Data Cer')
                ->assertNotPresent('a[href="' . route('asset-requests.create') . '"]');
        });
    }

    public function test_can_access_index_and_have_permission_create()
    {
        $this->user->syncPermissions(['asset_request_read', 'asset_request_create']);
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user->getKey())
                ->visitRoute('asset-requests.index')
                ->assertTitle('Cer')
                ->assertSee('Data Cer')
                ->assertPresent('a[href="' . route('asset-requests.create') . '"]');
        });
    }

    public function test_can_access_index_but_dosnt_have_permission_edit()
    {
        $this->user->syncPermissions(['asset_request_read']);
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user->getKey())
                ->visitRoute('asset-requests.index')
                ->assertTitle('Cer')
                ->assertSee('Data Cer')
                ->waitUntilMissing('#asset_request_table_processing')
                ->assertNotPresent('button.btn-edit');
        });
    }

    public function test_can_access_index_but_dosnt_have_permission_delete()
    {
        $this->user->syncPermissions(['asset_request_read']);
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user->getKey())
                ->visitRoute('asset-requests.index')
                ->assertTitle('Cer')
                ->assertSee('Data Cer')
                ->waitUntilMissing('#asset_request_table_processing')
                ->assertNotPresent('button.btn-delete');
        });
    }

    public function test_can_access_index_and_have_permission_delete()
    {
        $this->user->syncPermissions(['asset_request_read', 'asset_request_delete']);
        $this->browse(function (Browser $browser) {
            Cer::factory()->create([
                'nik' => $this->user->nik
            ]);

            $browser->loginAs($this->user->getKey())
                ->visitRoute('asset-requests.index')
                ->assertTitle('Cer')
                ->assertSee('Data Cer')
                ->waitUntilMissing('#asset_request_table_processing')
                ->assertPresent('button.btn-delete');
        });
    }

    public function test_can_access_form_cer_via_button()
    {
        $this->browse(function (Browser $browser) {
            $user = User::factory()->create([
                'nik' => 12130081
            ]);
            $user->syncPermissions(['asset_request_read', 'asset_request_create']);

            $browser->loginAs($user->getKey())
                ->visitRoute('asset-requests.index')
                ->assertTitle('Cer')
                ->assertSee('Data Cer')
                ->click('a[href="' . route('asset-requests.create') . '"]')
                ->assertTitle('Create Cer');
        });
    }

    // public function test_can_adding_data_from_form_cer()
    // {
    //     $this->user->syncPermissions(['asset_request_read', 'asset_request_create']);
    //     $this->browse(function (Browser $browser) {
    //         Cer::factory()->make([
    //             'nik' => $this->user->nik
    //         ]);

    //         $browser->loginAs($this->user->getKey())
    //             ->visitRoute('asset-requests.index')
    //             ->assertTitle('Create Cer')
    //             ->assertSee('Create Cer')
    //             ->click('a[href="' . route('asset-requests.create') . '"]');
    //     });
    // }
}
