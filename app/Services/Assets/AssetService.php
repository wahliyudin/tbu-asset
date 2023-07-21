<?php

namespace App\Services\Assets;

use App\DataTransferObjects\Assets\AssetData;
use App\DataTransferObjects\Assets\AssetInsuranceData;
use App\DataTransferObjects\Assets\AssetLeasingData;
use App\DataTransferObjects\Masters\CategoryData;
use App\DataTransferObjects\Masters\ClusterData;
use App\DataTransferObjects\Masters\SubClusterData;
use App\DataTransferObjects\Masters\UnitData;
use App\DataTransferObjects\Masters\UomData;
use App\Enums\Asset\Status;
use App\Facades\Elasticsearch;
use App\Http\Requests\Assets\AssetRequest;
use App\Models\Assets\Asset;
use App\Repositories\Assets\AssetInsuranceRepository;
use App\Repositories\Assets\AssetLeasingRepository;
use App\Repositories\Assets\AssetRepository;
use App\Services\Masters\CategoryService;
use App\Services\Masters\ClusterService;
use App\Services\Masters\SubClusterService;
use App\Services\Masters\UnitService;
use App\Services\Masters\UomService;
use Illuminate\Support\Arr;
use PhpOffice\PhpSpreadsheet\Chart\Chart;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

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
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'Category');
        $sheet->setCellValue('B1', 'Value');

        $sheet->setCellValue('A2', 'Category 1');
        $sheet->setCellValue('B2', 30);

        $sheet->setCellValue('A3', 'Category 2');
        $sheet->setCellValue('B3', 50);

        $sheet->setCellValue('A4', 'Category 3');
        $sheet->setCellValue('B4', 20);

        $chart = new Chart('PieChart', null, null, null, true);
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
        $asset->load(['unit', 'subCluster', 'depreciations', 'depreciation', 'insurance', 'leasing', 'uom']);
        $this->sendToElasticsearch($asset, $data->getKey());
    }

    public function delete(Asset $asset)
    {
        $this->assetInsuranceRepository->delete($asset->insurance);
        $this->assetLeasingRepository->delete($asset->leasing);
        Elasticsearch::setModel(Asset::class)->deleted(AssetData::from($asset));
        return $asset->delete();
    }

    public function import(array $data)
    {
        Elasticsearch::setModel(Asset::class)->cleared();
        Asset::query()->delete();
        Asset::query()->upsert($data, 'id');
        $this->bulk();
    }

    public function bulk()
    {
        $assets = Asset::query()->with(['unit', 'subCluster', 'depreciations', 'depreciation', 'insurance', 'leasing', 'uom'])->get();
        Elasticsearch::setModel(Asset::class)->bulk(AssetData::collection($assets));
    }

    private function sendToElasticsearch(Asset $asset, $key)
    {
        if ($key) {
            return Elasticsearch::setModel(Asset::class)->updated(AssetData::from($asset));
        }
        return Elasticsearch::setModel(Asset::class)->created(AssetData::from($asset));
    }
}
