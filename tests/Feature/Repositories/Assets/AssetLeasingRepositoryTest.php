<?php

namespace Tests\Feature\Repositories\Assets;

use App\DataTransferObjects\Assets\AssetLeasingData;
use App\Models\Assets\Asset;
use App\Models\Assets\AssetLeasing;
use App\Repositories\Assets\AssetLeasingRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AssetLeasingRepositoryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_by_asset()
    {
        $asset = Asset::factory()->create();
        $assetLeasing = AssetLeasing::factory()->make([
            'asset_id' => $asset->getKey()
        ]);
        $assetLeasingData = AssetLeasingData::from($assetLeasing);

        $assetLeasingRepository = new AssetLeasingRepository();
        $result = $assetLeasingRepository->updateOrCreateByAsset($assetLeasingData, $asset);

        $this->assertEquals($assetLeasing->asset_id, $result->asset_id);
        $this->assertEquals($assetLeasing->dealer_id, $result->dealer_id);
        $this->assertEquals($assetLeasing->leasing_id, $result->leasing_id);
        $this->assertEquals($assetLeasing->harga_beli, $result->harga_beli);
        $this->assertEquals($assetLeasing->jangka_waktu_leasing, $result->jangka_waktu_leasing);
        $this->assertEquals($assetLeasing->biaya_leasing, $result->biaya_leasing);
        $this->assertEquals($assetLeasing->legalitas, $result->legalitas);
    }

    /** @test */
    public function it_can_delete_data()
    {
        $assetLeasing = AssetLeasing::factory()->create();

        $assetLeasingRepository = new AssetLeasingRepository();
        $assetLeasingRepository->delete($assetLeasing);

        $this->assertModelMissing($assetLeasing);
    }
}
