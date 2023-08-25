<?php

namespace Tests\Browser\Disposes;

use App\Models\Disposes\AssetDispose;
use App\Models\User;
use Database\Seeders\SidebarWithPermissionSeeder;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class AssetDisposeTest extends DuskTestCase
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
                ->visitRoute('asset-disposes.index')
                ->assertTitle('Dilarang')
                ->assertSee('403');
        });
    }

    public function test_can_access_index()
    {
        $this->user->syncPermissions(['asset_dispose_read']);
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user->getKey())
                ->visitRoute('asset-disposes.index')
                ->assertTitle('Dispose')
                ->assertSee('Data Dispose');
        });
    }

    public function test_can_access_index_but_dosnt_have_permission_create()
    {
        $this->user->syncPermissions(['asset_dispose_read']);
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user->getKey())
                ->visitRoute('asset-disposes.index')
                ->assertTitle('Dispose')
                ->assertSee('Data Dispose')
                ->assertNotPresent('a[href="' . route('asset-disposes.create') . '"]');
        });
    }

    public function test_can_access_index_and_have_permission_create()
    {
        $this->user->syncPermissions(['asset_dispose_read', 'asset_dispose_create']);
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user->getKey())
                ->visitRoute('asset-disposes.index')
                ->assertTitle('Dispose')
                ->assertSee('Data Dispose')
                ->assertPresent('a[href="' . route('asset-disposes.create') . '"]');
        });
    }

    public function test_can_access_index_but_dosnt_have_permission_edit()
    {
        $this->user->syncPermissions(['asset_dispose_read']);
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user->getKey())
                ->visitRoute('asset-disposes.index')
                ->assertTitle('Dispose')
                ->assertSee('Data Dispose')
                ->waitUntilMissing('#dispose_table_processing')
                ->assertNotPresent('button.btn-edit');
        });
    }

    public function test_can_access_index_but_dosnt_have_permission_delete()
    {
        $this->user->syncPermissions(['asset_dispose_read']);
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user->getKey())
                ->visitRoute('asset-disposes.index')
                ->assertTitle('Dispose')
                ->assertSee('Data Dispose')
                ->waitUntilMissing('#dispose_table_processing')
                ->assertNotPresent('button.btn-delete');
        });
    }

    public function test_can_access_index_and_have_permission_delete()
    {
        $this->user->syncPermissions(['asset_dispose_read', 'asset_dispose_delete']);
        $this->browse(function (Browser $browser) {
            AssetDispose::factory()->create([
                'nik' => $this->user->nik
            ]);

            $browser->loginAs($this->user->getKey())
                ->visitRoute('asset-disposes.index')
                ->assertTitle('Dispose')
                ->assertSee('Data Dispose')
                ->waitUntilMissing('#dispose_table_processing')
                ->assertPresent('button.btn-delete');
        });
    }
}
