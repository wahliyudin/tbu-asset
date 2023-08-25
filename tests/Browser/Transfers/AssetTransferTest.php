<?php

namespace Tests\Browser\Transfers;

use App\Models\Transfers\AssetTransfer;
use App\Models\User;
use Database\Seeders\SidebarWithPermissionSeeder;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class AssetTransferTest extends DuskTestCase
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
                ->visitRoute('asset-transfers.index')
                ->assertTitle('Dilarang')
                ->assertSee('403');
        });
    }

    public function test_can_access_index()
    {
        $this->user->syncPermissions(['asset_transfer_read']);
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user->getKey())
                ->visitRoute('asset-transfers.index')
                ->assertTitle('Transfer')
                ->assertSee('Data Transfer');
        });
    }

    public function test_can_access_index_but_dosnt_have_permission_create()
    {
        $this->user->syncPermissions(['asset_transfer_read']);
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user->getKey())
                ->visitRoute('asset-transfers.index')
                ->assertTitle('Transfer')
                ->assertSee('Data Transfer')
                ->assertNotPresent('a[href="' . route('asset-transfers.create') . '"]');
        });
    }

    public function test_can_access_index_and_have_permission_create()
    {
        $this->user->syncPermissions(['asset_transfer_read', 'asset_transfer_create']);
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user->getKey())
                ->visitRoute('asset-transfers.index')
                ->assertTitle('Transfer')
                ->assertSee('Data Transfer')
                ->assertPresent('a[href="' . route('asset-transfers.create') . '"]');
        });
    }

    public function test_can_access_index_but_dosnt_have_permission_edit()
    {
        $this->user->syncPermissions(['asset_transfer_read']);
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user->getKey())
                ->visitRoute('asset-transfers.index')
                ->assertTitle('Transfer')
                ->assertSee('Data Transfer')
                ->waitUntilMissing('#asset_transfer_table_processing')
                ->assertNotPresent('button.btn-edit');
        });
    }

    public function test_can_access_index_but_dosnt_have_permission_delete()
    {
        $this->user->syncPermissions(['asset_transfer_read']);
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user->getKey())
                ->visitRoute('asset-transfers.index')
                ->assertTitle('Transfer')
                ->assertSee('Data Transfer')
                ->waitUntilMissing('#asset_transfer_table_processing')
                ->assertNotPresent('button.btn-delete');
        });
    }

    public function test_can_access_index_and_have_permission_delete()
    {
        $this->user->syncPermissions(['asset_transfer_read', 'asset_transfer_delete']);
        $this->browse(function (Browser $browser) {
            AssetTransfer::factory()->create([
                'nik' => $this->user->nik
            ]);

            $browser->loginAs($this->user->getKey())
                ->visitRoute('asset-transfers.index')
                ->assertTitle('Transfer')
                ->assertSee('Data Transfer')
                ->waitUntilMissing('#asset_transfer_table_processing')
                ->assertPresent('button.btn-delete');
        });
    }
}
