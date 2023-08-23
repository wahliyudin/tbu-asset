<?php

namespace Tests\Feature\Approval;

use App\Enums\Workflows\LastAction;
use App\Models\Cers\Cer;
use App\Models\Cers\CerWorkflow;
use App\Models\User;
use Database\Seeders\SidebarWithPermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ApprovalCerTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(SidebarWithPermissionSeeder::class);
        $this->user = User::factory()->create();
    }

    public function createCer()
    {
        $cer = Cer::factory()->create([
            'nik' => $this->user->nik
        ]);
        CerWorkflow::factory()->create([
            'cer_id' => $cer->getKey(),
            'nik' => $this->user->nik,
            'last_action' => LastAction::NOTTING
        ]);
        return $cer;
    }

    public function test_can_access_index()
    {
        $this->user->givePermissions(['asset_request_approv', 'asset_request_reject']);
        $response = $this->actingAs($this->user)
            ->get(route('approvals.cers.index'));

        $response->assertOk();
    }

    public function test_can_access_and_dosnt_have_any_data_datatable()
    {
        $this->user->givePermissions(['asset_request_approv', 'asset_request_reject']);
        $response = $this->actingAs($this->user)
            ->post(route('approvals.cers.datatable'));

        $data = $response->json();
        $response->assertOk();
        $this->assertSame(0, $data['recordsTotal']);
    }

    public function test_can_access_and_with_data_datatable()
    {
        $this->createCer();
        $this->user->givePermissions(['asset_request_approv', 'asset_request_reject']);
        $response = $this->actingAs($this->user)
            ->post(route('approvals.cers.datatable'));

        $data = $response->json();
        $response->assertOk();
        $this->assertSame(1, $data['recordsTotal']);
    }

    public function test_can_access_show()
    {
        $cer = $this->createCer();
        $this->user->givePermissions(['asset_request_approv', 'asset_request_reject']);
        $response = $this->actingAs($this->user)
            ->post(route('approvals.cers.show', $cer->getKey()));

        $response->assertSeeText('Approval Show Cer');
    }

    public function test_can_approv()
    {
        $cer = $this->createCer();
        $this->user->givePermissions(['asset_request_approv', 'asset_request_reject']);
        $response = $this->actingAs($this->user)
            ->post(route('approvals.cers.approv', $cer->getKey()));

        $response->assertOk();
        $response->assertJson([
            'message' => 'Berhasil Diverifikasi.'
        ]);
    }

    public function test_can_reject()
    {
        $cer = $this->createCer();
        $this->user->givePermissions(['asset_request_approv', 'asset_request_reject']);
        $response = $this->actingAs($this->user)
            ->post(route('approvals.cers.reject', $cer->getKey()));

        $response->assertOk();
        $response->assertJson([
            'message' => 'Berhasil Direject.'
        ]);
    }
}
