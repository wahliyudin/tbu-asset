<?php

namespace Tests\Feature\Approval;

use App\Enums\Workflows\LastAction;
use App\Models\Disposes\AssetDispose;
use App\Models\Disposes\DisposeWorkflow;
use App\Models\User;
use Database\Seeders\SidebarWithPermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ApprovalDisposeTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(SidebarWithPermissionSeeder::class);
        $this->user = User::factory()->create();
    }

    public function createAssetDispose()
    {
        $assetDispose = AssetDispose::factory()->create([
            'nik' => $this->user->nik
        ]);
        DisposeWorkflow::factory()->create([
            'asset_dispose_id' => $assetDispose->getKey(),
            'nik' => $this->user->nik,
            'last_action' => LastAction::NOTTING
        ]);
        return $assetDispose;
    }

    public function test_can_access_index()
    {
        $this->user->givePermissions(['asset_dispose_approv', 'asset_dispose_reject']);
        $response = $this->actingAs($this->user)
            ->get(route('approvals.disposes.index'));

        $response->assertOk();
    }

    public function test_can_access_and_dosnt_have_any_data_datatable()
    {
        $this->user->givePermissions(['asset_dispose_approv', 'asset_dispose_reject']);
        $response = $this->actingAs($this->user)
            ->post(route('approvals.disposes.datatable'));

        $data = $response->json();
        $response->assertOk();
        $this->assertSame(0, $data['recordsTotal']);
    }

    public function test_can_access_and_with_data_datatable()
    {
        $this->createAssetDispose();
        $this->user->givePermissions(['asset_dispose_approv', 'asset_dispose_reject']);
        $response = $this->actingAs($this->user)
            ->post(route('approvals.disposes.datatable'));

        $data = $response->json();
        $response->assertOk();
        $this->assertSame(1, $data['recordsTotal']);
    }

    public function test_can_access_show()
    {
        $assetDispose = $this->createAssetDispose();
        $this->user->givePermissions(['asset_dispose_approv', 'asset_dispose_reject']);
        $response = $this->actingAs($this->user)
            ->post(route('approvals.disposes.show', $assetDispose->getKey()));

        $response->assertSeeText('Approval Show Asset Dispose');
    }

    public function test_can_approv()
    {
        $assetDispose = $this->createAssetDispose();
        $this->user->givePermissions(['asset_dispose_approv', 'asset_dispose_reject']);
        $response = $this->actingAs($this->user)
            ->post(route('approvals.disposes.approv', $assetDispose->getKey()));

        $response->assertOk();
        $response->assertJson([
            'message' => 'Berhasil Diverifikasi.'
        ]);
    }

    public function test_can_reject()
    {
        $assetDispose = $this->createAssetDispose();
        $this->user->givePermissions(['asset_dispose_approv', 'asset_dispose_reject']);
        $response = $this->actingAs($this->user)
            ->post(route('approvals.disposes.reject', $assetDispose->getKey()));

        $response->assertOk();
        $response->assertJson([
            'message' => 'Berhasil Direject.'
        ]);
    }
}
