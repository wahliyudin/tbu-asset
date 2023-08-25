<?php

namespace Tests\Feature\Repositories\Assets;

use App\DataTransferObjects\Assets\AssetData;
use App\Models\Assets\Asset;
use App\Repositories\Assets\AssetRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AssetRepositoryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_data()
    {
        $asset = Asset::factory()->make();
        $assetData = AssetData::from($asset);

        $assetRepository = new AssetRepository();
        $result = $assetRepository->updateOrCreate($assetData);

        $this->assertEquals($asset->kode, $result->kode);
        $this->assertEquals($asset->unit_id, $result->unit_id);
        $this->assertEquals($asset->sub_cluster_id, $result->sub_cluster_id);
        $this->assertEquals($asset->member_name, $result->member_name);
        $this->assertEquals($asset->pic, $result->pic);
        $this->assertEquals($asset->activity, $result->activity);
        $this->assertEquals($asset->asset_location, $result->asset_location);
        $this->assertEquals($asset->kondisi, $result->kondisi);
        $this->assertEquals($asset->uom, $result->uom);
        $this->assertEquals($asset->quantity, $result->quantity);
        $this->assertEquals($asset->tgl_bast, $result->tgl_bast);
        $this->assertEquals($asset->hm, $result->hm);
        $this->assertEquals($asset->pr_number, $result->pr_number);
        $this->assertEquals($asset->po_number, $result->po_number);
        $this->assertEquals($asset->gr_number, $result->gr_number);
        $this->assertEquals($asset->remark, $result->remark);
        $this->assertEquals($asset->status, $result->status);
    }

    /** @test */
    public function it_can_update_data()
    {
        $asset = Asset::factory()->create();

        $newAsset = Asset::factory()->make();
        $assetData = AssetData::from(array_merge(['key' => $asset->getKey()], $newAsset->toArray()));

        $assetRepository = new AssetRepository();
        $result = $assetRepository->updateOrCreate($assetData);

        $this->assertEquals($newAsset->kode, $result->kode);
        $this->assertEquals($newAsset->unit_id, $result->unit_id);
        $this->assertEquals($newAsset->sub_cluster_id, $result->sub_cluster_id);
        $this->assertEquals($newAsset->member_name, $result->member_name);
        $this->assertEquals($newAsset->pic, $result->pic);
        $this->assertEquals($newAsset->activity, $result->activity);
        $this->assertEquals($newAsset->asset_location, $result->asset_location);
        $this->assertEquals($newAsset->kondisi, $result->kondisi);
        $this->assertEquals($newAsset->uom, $result->uom);
        $this->assertEquals($newAsset->quantity, $result->quantity);
        $this->assertEquals($newAsset->tgl_bast, $result->tgl_bast);
        $this->assertEquals($newAsset->hm, $result->hm);
        $this->assertEquals($newAsset->pr_number, $result->pr_number);
        $this->assertEquals($newAsset->po_number, $result->po_number);
        $this->assertEquals($newAsset->gr_number, $result->gr_number);
        $this->assertEquals($newAsset->remark, $result->remark);
        $this->assertEquals($newAsset->status, $result->status);
    }
}
