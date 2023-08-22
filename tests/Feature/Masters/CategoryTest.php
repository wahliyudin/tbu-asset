<?php

namespace Tests\Feature\Masters;

use App\Models\Masters\Category;
use App\Models\User;
use Database\Seeders\SidebarWithPermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

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
        $response = $this->actingAs($this->user)
            ->get(route('masters.categories.index'));
        $response->assertSee('Data Category');
    }

    public function test_user_dosnt_have_access_index()
    {
        $response = $this->actingAs($this->user)
            ->get(route('masters.categories.index'));
        $response->assertForbidden();
    }

    public function test_can_access_and_dosnt_have_any_data_datatable()
    {
        $this->user->givePermission('category_read');
        $response = $this->actingAs($this->user)
            ->post(route('masters.categories.datatable'));

        $data = $response->json();
        $response->assertOk();
        $this->assertSame(0, $data['recordsTotal']);
    }

    public function test_can_access_and_with_data_datatable()
    {
        Category::factory(5)->create();
        $this->user->givePermission('category_read');
        $response = $this->actingAs($this->user)
            ->post(route('masters.categories.datatable'));

        $data = $response->json();
        $response->assertOk();
        $this->assertSame(5, $data['recordsTotal']);
    }

    public function test_can_create_one_data()
    {
        $category = Category::factory()->make();
        $this->user->givePermission('category_create');
        $response = $this->actingAs($this->user)
            ->post(route('masters.categories.store'), $category->toArray());

        $response->assertOk()
            ->assertJson([
                'message' => 'Berhasil disimpan'
            ]);
        $this->assertDatabaseCount(Category::class, 1);
    }

    public function test_create_category_with_invalid_data()
    {
        $category = Category::factory()->make([
            'name' => null
        ]);
        $this->user->givePermission('category_create');
        $response = $this->actingAs($this->user)
            ->post(route('masters.categories.store'), $category->toArray());

        $response->assertInvalid();
        $this->assertDatabaseEmpty(Category::class);
    }

    public function test_can_edit_data()
    {
        $category = Category::factory()->create();
        $this->user->givePermission('category_update');
        $response = $this->actingAs($this->user)
            ->post(route('masters.categories.edit', $category->getKey()));

        $response->assertOk();
        $response->assertJson($category->toArray());
    }

    public function test_access_edit_data_not_found()
    {
        $this->user->givePermission('category_update');
        $response = $this->actingAs($this->user)
            ->post(route('masters.categories.edit', 1));

        $response->assertNotFound();
    }

    public function test_can_delete_data()
    {
        $category = Category::factory()->create();
        $this->user->givePermission('category_delete');
        $response = $this->actingAs($this->user)
            ->delete(route('masters.categories.destroy', $category->getKey()));

        $response->assertOk();
        $response->assertJson([
            'message' => 'Berhasil dihapus'
        ]);
        $this->assertDatabaseEmpty(Category::class);
    }
}
