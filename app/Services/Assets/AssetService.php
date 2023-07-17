<?php

namespace App\Services\Assets;

use App\DataTransferObjects\Assets\AssetData;
use App\DataTransferObjects\Assets\AssetInsuranceData;
use App\DataTransferObjects\Assets\AssetLeasingData;
use App\Enums\Asset\Status;
use App\Facades\Elasticsearch;
use App\Http\Requests\Assets\AssetRequest;
use App\Http\Requests\Assets\ImportRequest;
use App\Imports\Assets\AssetImport;
use App\Models\Assets\Asset;
use App\Repositories\Assets\AssetInsuranceRepository;
use App\Repositories\Assets\AssetLeasingRepository;
use App\Repositories\Assets\AssetRepository;
use Maatwebsite\Excel\Facades\Excel;

class AssetService
{
    public function __construct(
        protected AssetRepository $assetRepository,
        protected AssetInsuranceRepository $assetInsuranceRepository,
        protected AssetLeasingRepository $assetLeasingRepository,
    ) {
    }

    public function all($search = null)
    {
        return Elasticsearch::setModel(Asset::class)->searchQueryString($search, 50)->all();
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
        $asset = $this->assetRepository->updateOrCreate($data);
        $this->assetInsuranceRepository->updateOrCreateByAsset(AssetInsuranceData::fromRequest($request), $asset);
        $this->assetLeasingRepository->updateOrCreateByAsset(AssetLeasingData::fromRequest($request), $asset);
        $asset->load(['unit', 'subCluster', 'depreciations', 'depreciation', 'insurance', 'leasing']);
        $this->sendToElasticsearch($asset, $data->getKey());
    }

    public function delete(Asset $asset)
    {
        $this->assetInsuranceRepository->delete($asset->insurance);
        $this->assetLeasingRepository->delete($asset->leasing);
        Elasticsearch::setModel(Asset::class)->deleted(AssetData::from($asset));
        return $asset->delete();
    }

    public function import(ImportRequest $request)
    {
        Elasticsearch::setModel(Asset::class)->cleared();
        Excel::import(new AssetImport(), $request->file('file'));
        return $this->bulk();
    }

    public function bulk()
    {
        $assets = Asset::query()->with(['unit', 'subCluster', 'depreciations', 'depreciation', 'insurance', 'leasing'])->get();
        return Elasticsearch::setModel(Asset::class)->bulk(AssetData::collection($assets));
    }

    private function sendToElasticsearch(Asset $asset, $key)
    {
        if ($key) {
            return Elasticsearch::setModel(Asset::class)->updated(AssetData::from($asset));
        }
        return Elasticsearch::setModel(Asset::class)->created(AssetData::from($asset));
    }
}
