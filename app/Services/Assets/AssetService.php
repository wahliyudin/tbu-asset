<?php

namespace App\Services\Assets;

use App\DataTransferObjects\Assets\AssetData;
use App\DataTransferObjects\Assets\AssetInsuranceData;
use App\DataTransferObjects\Assets\AssetLeasingData;
use App\Enums\Asset\Status;
use App\Facades\Elasticsearch;
use App\Http\Requests\Assets\AssetRequest;
use App\Jobs\Assets\BulkJob;
use App\Jobs\Assets\ImportJob;
use App\Models\Assets\Asset;
use App\Repositories\Assets\AssetInsuranceRepository;
use App\Repositories\Assets\AssetLeasingRepository;
use App\Repositories\Assets\AssetRepository;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\DB;

class AssetService
{
    public function __construct(
        protected AssetRepository $assetRepository,
        protected AssetInsuranceRepository $assetInsuranceRepository,
        protected AssetLeasingRepository $assetLeasingRepository,
    ) {
    }

    public function coba()
    {
        return Asset::query()->with(['unit', 'leasing', 'insurance'])->get();
    }

    public function all($search = null)
    {
        return Elasticsearch::setModel(Asset::class)->searchMultiMatch($search, 50)->all();
    }

    public function getById($id)
    {
        return Asset::query()->find($id);
    }

    public function getByStatus(Status $status)
    {
        return Asset::query()->where('status', $status)->get();
    }

    public function getDataForEdit($id): array
    {
        $asset = Elasticsearch::setModel(Asset::class)->find($id)->asArray();
        return $asset['_source'];
    }

    public function updateOrCreate(AssetRequest $request)
    {
        $data = AssetData::from($request->all());
        DB::transaction(function () use ($data, $request) {
            $asset = $this->assetRepository->updateOrCreate($data);
            $this->assetInsuranceRepository->updateOrCreateByAsset(AssetInsuranceData::fromRequest($request), $asset);
            $this->assetLeasingRepository->updateOrCreateByAsset(AssetLeasingData::fromRequest($request), $asset);
            $this->sendToElasticsearch($asset, $data->getKey());
        });
    }

    public function delete(Asset $asset)
    {
        return DB::transaction(function () use ($asset) {
            $this->assetInsuranceRepository->delete($asset->insurance);
            $this->assetLeasingRepository->delete($asset->leasing);
            Elasticsearch::setModel(Asset::class)->deleted(AssetData::from($asset));
            return $asset->delete();
        });
    }

    public function import(array $data)
    {
        Asset::truncate();
        Elasticsearch::setModel(Asset::class)->cleared();
        $batch = Bus::batch([])->dispatch();
        foreach (array_chunk($data, 10) as $assets) {
            $batch->add(new ImportJob($assets));
        }
        return $batch;
    }

    public function startBulk()
    {
        $batch = Bus::batch([])->dispatch();
        $assets = $this->getDataBulk()?->toArray();
        foreach (array_chunk($assets, 10) as $assets) {
            $batch->add(new BulkJob($assets));
        }
        return $batch;
    }

    public static function bulk(array $assets = [])
    {
        $assets = count($assets) > 0 ? $assets : self::getDataBulk();
        Elasticsearch::setModel(Asset::class)->bulk(AssetData::collection($assets));
    }

    private static function getDataBulk()
    {
        return Asset::query()->with(['unit', 'subCluster', 'depreciations', 'depreciation', 'insurance', 'leasing', 'uom'])->get();
    }

    private function sendToElasticsearch(Asset $asset, $key)
    {
        $asset->load(['unit', 'subCluster', 'depreciations', 'depreciation', 'insurance', 'leasing', 'uom']);
        if ($key) {
            return Elasticsearch::setModel(Asset::class)->updated(AssetData::from($asset));
        }
        return Elasticsearch::setModel(Asset::class)->created(AssetData::from($asset));
    }
}
