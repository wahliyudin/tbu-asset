<?php

namespace Tests\Feature\Repositories\Disposes;

use App\DataTransferObjects\Disposes\AssetDisposeData;
use App\Models\Disposes\AssetDispose;
use App\Models\User;
use App\Repositories\Disposes\AssetDisposeRepository;
use Database\Seeders\SidebarWithPermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AssetDisposeRepositoryTest extends TestCase
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
        $assetDispose = AssetDispose::factory()->make();
        $assetDisposeData = AssetDisposeData::from($assetDispose);

        $assetDisposeRepository = new AssetDisposeRepository();
        $result = $assetDisposeRepository->updateOrCreate($assetDisposeData);

        $this->assertEquals($assetDispose->asset_id, $result->asset_id);
        // $this->assertEquals($assetDispose->no_dispose, $result->no_dispose);
        // $this->assertEquals($assetDispose->nik, $result->nik);
        $this->assertEquals($assetDispose->nilai_buku, $result->nilai_buku);
        $this->assertEquals($assetDispose->est_harga_pasar, $result->est_harga_pasar);
        $this->assertEquals($assetDispose->notes, $result->notes);
        $this->assertEquals($assetDispose->justifikasi, $result->justifikasi);
        $this->assertEquals($assetDispose->pelaksanaan, $result->pelaksanaan);
        $this->assertEquals($assetDispose->remark, $result->remark);
        $this->assertEquals($assetDispose->status, $result->status);
    }

    /** @test */
    public function it_can_update_data()
    {
        $this->actingAs($this->user);
        $assetDispose = AssetDispose::factory()->create();

        $newAssetDispose = AssetDispose::factory()->make();
        $assetDisposeData = AssetDisposeData::from(array_merge(['key' => $assetDispose->getKey()], $newAssetDispose->toArray()));

        $assetDisposeRepository = new AssetDisposeRepository();
        $result = $assetDisposeRepository->updateOrCreate($assetDisposeData);

        $this->assertEquals($newAssetDispose->asset_id, $result->asset_id);
        // $this->assertEquals($newAssetDispose->no_dispose, $result->no_dispose);
        // $this->assertEquals($newAssetDispose->nik, $result->nik);
        $this->assertEquals($newAssetDispose->nilai_buku, $result->nilai_buku);
        $this->assertEquals($newAssetDispose->est_harga_pasar, $result->est_harga_pasar);
        $this->assertEquals($newAssetDispose->notes, $result->notes);
        $this->assertEquals($newAssetDispose->justifikasi, $result->justifikasi);
        $this->assertEquals($newAssetDispose->pelaksanaan, $result->pelaksanaan);
        $this->assertEquals($newAssetDispose->remark, $result->remark);
        $this->assertEquals($newAssetDispose->status, $result->status);
    }
}
