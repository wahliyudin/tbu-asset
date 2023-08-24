<?php

namespace Tests\Browser\Masters;

use App\Models\Masters\Category;
use App\Models\User;
use Database\Seeders\SidebarWithPermissionSeeder;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class CategoryTest extends DuskTestCase
{
    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(SidebarWithPermissionSeeder::class);
        $this->user = User::factory()->create();
    }

    public function test_can_access_index()
    {
        $this->user->givePermission('category_read');
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user->getKey())
                ->visitRoute('masters.categories.index')
                ->assertTitle('Category')
                ->assertSee('Data Category');
        });
    }

    public function test_can_not_access_index()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user->getKey())
                ->visitRoute('masters.categories.index')
                ->assertTitle('Dilarang')
                ->assertSee('403');
        });
    }

    public function test_can_access_index_but_user_dosnt_have_permission_create_because_button_add_category_not_present()
    {
        $this->user->givePermission('category_read');
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user->getKey())
                ->visitRoute('masters.categories.index')
                ->assertNotPresent('button[data-bs-target="#create-category"]');
        });
    }

    public function test_click_button_add_category_and_then_modal_appear()
    {
        $this->user->givePermissions(['category_read', 'category_create']);
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user->getKey())
                ->visitRoute('masters.categories.index')
                ->click('button[data-bs-target="#create-category"]')
                ->waitFor('#create-category', 1)
                ->assertSee('Tambah Category');
        });
    }

    public function test_adding_data_via_modal()
    {
        $this->user->givePermissions(['category_read', 'category_create']);
        $this->browse(function (Browser $browser) {
            $category = fake()->sentence(1);
            $browser->loginAs($this->user->getKey())
                ->visitRoute('masters.categories.index')
                ->click('button[data-bs-target="#create-category"]')
                ->waitFor('#create-category')
                ->assertSee('Tambah Category')
                ->type('input[name="name"]', $category)
                ->press('button#create-category_submit')
                ->waitUntilMissing('#create-category_submit.indicator-progress')
                ->waitForText('successfully')
                ->click('button.swal2-confirm')
                ->waitFor('table#category_table')
                ->assertSee('Loading')
                ->waitUntilMissing('#category_table_processing')
                ->type('input[data-kt-category-table-filter="search"]', $category)
                ->keys('input[data-kt-category-table-filter="search"]', '{enter}')
                ->waitUntilMissing('#category_table_processing')
                ->assertSee($category);
        });
    }

    public function test_edit_data_via_modal()
    {
        $category = Category::factory()->create();
        $this->user->givePermissions(['category_read', 'category_update']);
        $this->browse(function (Browser $browser) use ($category) {
            $newCategory = fake()->sentence(1);
            $browser->loginAs($this->user->getKey())
                ->visitRoute('masters.categories.index')
                ->waitUntilMissing('#category_table_processing')
                ->type('input[data-kt-category-table-filter="search"]', $category->name)
                ->keys('input[data-kt-category-table-filter="search"]', '{enter}')
                ->waitUntilMissing('#category_table_processing')
                ->click('button.btn-edit[data-category="' . $category->getKey() . '"]')
                ->waitFor('#create-category')
                ->assertSee('Edit Category')
                ->type('input[name="name"]', $newCategory)
                ->press('button#create-category_submit')
                ->waitUntilMissing('#create-category_submit.indicator-progress')
                ->waitFor('.swal2-container')
                ->click('button.swal2-confirm')
                ->waitFor('table#category_table')
                ->click('#create-category_close')
                ->click('button.swal2-confirm')
                ->waitUntilMissing('#category_table_processing')
                ->type('input[data-kt-category-table-filter="search"]', $newCategory)
                ->keys('input[data-kt-category-table-filter="search"]', '{enter}')
                ->waitUntilMissing('#category_table_processing');
        });
    }

    public function test_delete_data()
    {
        $category = Category::factory()->create();
        $this->user->givePermissions(['category_read', 'category_delete']);
        $this->browse(function (Browser $browser) use ($category) {
            $browser->loginAs($this->user->getKey())
                ->visitRoute('masters.categories.index')
                ->waitUntilMissing('#category_table_processing')
                ->type('input[data-kt-category-table-filter="search"]', $category->name)
                ->keys('input[data-kt-category-table-filter="search"]', '{enter}')
                ->waitUntilMissing('#category_table_processing')
                ->click('button.btn-delete[data-category="' . $category->getKey() . '"]')
                ->waitFor('div.swal2-popup.swal2-icon-warning')
                ->click('button.swal2-confirm')
                ->waitFor('div.swal2-popup.swal2-icon-success')
                ->click('button.swal2-confirm')
                ->waitUntilMissing('#category_table_processing')
                ->type('input[data-kt-category-table-filter="search"]', $category->name)
                ->keys('input[data-kt-category-table-filter="search"]', '{enter}')
                ->waitUntilMissing('#category_table_processing')
                ->assertSee('No matching records found');
        });
    }
}
