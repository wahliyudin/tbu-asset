<?php

namespace Tests\Feature\Repositories\Transfers;

use App\DataTransferObjects\Transfers\AssetTransferData;
use App\Models\Transfers\AssetTransfer;
use App\Models\User;
use App\Repositories\Transfers\AssetTransferRepository;
use Database\Seeders\SidebarWithPermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AssetTransferRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(SidebarWithPermissionSeeder::class);
        $this->user = User::factory()->create();
    }

    /** @test */
    public function it_can_create_data()
    {
        $this->actingAs($this->user);
        $assetTransfer = AssetTransfer::factory()->make();
        $assetTransferData = AssetTransferData::from($assetTransfer);

        $assetTransferRepository = new AssetTransferRepository();
        $result = $assetTransferRepository->updateOrCreate($assetTransferData);

        // $this->assertEquals($assetTransfer->no_transaksi, $result->no_transaksi);
        // $this->assertEquals($assetTransfer->nik, $result->nik);
        $this->assertEquals($assetTransfer->asset_id, $result->asset_id);
        $this->assertEquals($assetTransfer->old_pic, $result->old_pic);
        $this->assertEquals($assetTransfer->old_location, $result->old_location);
        $this->assertEquals($assetTransfer->old_divisi, $result->old_divisi);
        $this->assertEquals($assetTransfer->old_department, $result->old_department);
        $this->assertEquals($assetTransfer->new_pic, $result->new_pic);
        $this->assertEquals($assetTransfer->new_location, $result->new_location);
        $this->assertEquals($assetTransfer->new_divisi, $result->new_divisi);
        $this->assertEquals($assetTransfer->new_department, $result->new_department);
        $this->assertEquals($assetTransfer->request_transfer_date, $result->request_transfer_date);
        $this->assertEquals($assetTransfer->justifikasi, $result->justifikasi);
        $this->assertEquals($assetTransfer->remark, $result->remark);
        $this->assertEquals($assetTransfer->transfer_date, $result->transfer_date);
        $this->assertEquals($assetTransfer->status, $result->status);
    }

    /** @test */
    public function it_can_update_data()
    {
        $this->actingAs($this->user);
        $assetTransfer = AssetTransfer::factory()->create();

        $newAssetTransfer = AssetTransfer::factory()->make();
        $assetTransferData = AssetTransferData::from(array_merge(['key' => $assetTransfer->getKey()], $newAssetTransfer->toArray()));

        $assetTransferRepository = new AssetTransferRepository();
        $result = $assetTransferRepository->updateOrCreate($assetTransferData);

        // $this->assertEquals($newAssetTransfer->no_transaksi, $result->no_transaksi);
        // $this->assertEquals($newAssetTransfer->nik, $result->nik);
        $this->assertEquals($newAssetTransfer->asset_id, $result->asset_id);
        $this->assertEquals($newAssetTransfer->old_pic, $result->old_pic);
        $this->assertEquals($newAssetTransfer->old_location, $result->old_location);
        $this->assertEquals($newAssetTransfer->old_divisi, $result->old_divisi);
        $this->assertEquals($newAssetTransfer->old_department, $result->old_department);
        $this->assertEquals($newAssetTransfer->new_pic, $result->new_pic);
        $this->assertEquals($newAssetTransfer->new_location, $result->new_location);
        $this->assertEquals($newAssetTransfer->new_divisi, $result->new_divisi);
        $this->assertEquals($newAssetTransfer->new_department, $result->new_department);
        $this->assertEquals($newAssetTransfer->request_transfer_date, $result->request_transfer_date);
        $this->assertEquals($newAssetTransfer->justifikasi, $result->justifikasi);
        $this->assertEquals($newAssetTransfer->remark, $result->remark);
        $this->assertEquals($newAssetTransfer->transfer_date, $result->transfer_date);
        $this->assertEquals($newAssetTransfer->status, $result->status);
    }
}
