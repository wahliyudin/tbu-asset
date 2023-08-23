<?php

namespace Tests\Feature\Approval;

use App\Enums\Workflows\LastAction;
use App\Models\Transfers\AssetTransfer;
use App\Models\Transfers\TransferWorkflow;
use App\Models\User;
use Database\Seeders\SidebarWithPermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ApprovalTransferTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(SidebarWithPermissionSeeder::class);
        $this->user = User::factory()->create();
    }

    public function createAssetTransfer()
    {
        $assetTransfer = AssetTransfer::factory()->create([
            'nik' => $this->user->nik
        ]);
        TransferWorkflow::factory()->create([
            'asset_transfer_id' => $assetTransfer->getKey(),
            'nik' => $this->user->nik,
            'last_action' => LastAction::NOTTING
        ]);
        return $assetTransfer;
    }

    public function test_can_access_index()
    {
        $this->user->givePermissions(['asset_transfer_approv', 'asset_transfer_reject']);
        $response = $this->actingAs($this->user)
            ->get(route('approvals.transfers.index'));

        $response->assertOk();
    }

    public function test_can_access_and_dosnt_have_any_data_datatable()
    {
        $this->user->givePermissions(['asset_transfer_approv', 'asset_transfer_reject']);
        $response = $this->actingAs($this->user)
            ->post(route('approvals.transfers.datatable'));

        $data = $response->json();
        $response->assertOk();
        $this->assertSame(0, $data['recordsTotal']);
    }

    public function test_can_access_and_with_data_datatable()
    {
        $this->createAssetTransfer();
        $this->user->givePermissions(['asset_transfer_approv', 'asset_transfer_reject']);
        $response = $this->actingAs($this->user)
            ->post(route('approvals.transfers.datatable'));

        $data = $response->json();
        $response->assertOk();
        $this->assertSame(1, $data['recordsTotal']);
    }

    public function test_can_access_show()
    {
        $assetTransfer = $this->createAssetTransfer();
        $this->user->givePermissions(['asset_transfer_approv', 'asset_transfer_reject']);
        $response = $this->actingAs($this->user)
            ->post(route('approvals.transfers.show', $assetTransfer->getKey()));

        $response->assertSeeText('Approval Show AssetTransfer');
    }

    public function test_can_approv()
    {
        $assetTransfer = $this->createAssetTransfer();
        $this->user->givePermissions(['asset_transfer_approv', 'asset_transfer_reject']);
        $response = $this->actingAs($this->user)
            ->post(route('approvals.transfers.approv', $assetTransfer->getKey()));

        $response->assertOk();
        $response->assertJson([
            'message' => 'Berhasil Diverifikasi.'
        ]);
    }

    public function test_can_reject()
    {
        $assetTransfer = $this->createAssetTransfer();
        $this->user->givePermissions(['asset_transfer_approv', 'asset_transfer_reject']);
        $response = $this->actingAs($this->user)
            ->post(route('approvals.transfers.reject', $assetTransfer->getKey()));

        $response->assertOk();
        $response->assertJson([
            'message' => 'Berhasil Direject.'
        ]);
    }
}
