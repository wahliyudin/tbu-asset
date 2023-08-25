<?php

namespace Tests\Feature\Repositories\Assets;

use App\DataTransferObjects\Assets\AssetInsuranceData;
use App\Models\Assets\Asset;
use App\Models\Assets\AssetInsurance;
use App\Repositories\Assets\AssetInsuranceRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AssetInsuranceRepositoryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_by_asset()
    {
        $asset = Asset::factory()->create();
        $assetInsurance = AssetInsurance::factory()->make([
            'asset_id' => $asset->getKey()
        ]);
        $assetInsuranceData = AssetInsuranceData::from($assetInsurance);

        $assetInsuranceRepository = new AssetInsuranceRepository();
        $result = $assetInsuranceRepository->updateOrCreateByAsset($assetInsuranceData, $asset);

        $this->assertEquals($assetInsurance->asset_id, $result->asset_id);
        $this->assertEquals($assetInsurance->jangka_waktu, $result->jangka_waktu);
        $this->assertEquals($assetInsurance->biaya, $result->biaya);
        $this->assertEquals($assetInsurance->legalitas, $result->legalitas);
    }

    /** @test */
    public function it_can_delete_data()
    {
        $assetInsurance = AssetInsurance::factory()->create();

        $assetInsuranceRepository = new AssetInsuranceRepository();
        $assetInsuranceRepository->delete($assetInsurance);

        $this->assertModelMissing($assetInsurance);
    }
}
