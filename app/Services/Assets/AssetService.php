<?php

namespace App\Services\Assets;

use App\DataTransferObjects\Assets\AssetData;
use App\DataTransferObjects\Assets\AssetInsuranceData;
use App\DataTransferObjects\Assets\AssetLeasingData;
use App\DataTransferObjects\Assets\AssetUnitData;
use App\Enums\Asset\Status;
use App\Facades\Elasticsearch;
use App\Facades\Masters\Category\CategoryService;
use App\Facades\Masters\Cluster\ClusterService;
use App\Facades\Masters\Leasing\LeasingService;
use App\Facades\Masters\SubCluster\SubClusterService;
use App\Facades\Masters\Unit\UnitService;
use App\Facades\Masters\Uom\UomService;
use App\Helpers\Helper;
use App\Http\Requests\Assets\AssetRequest;
use App\Jobs\Assets\BulkJob;
use App\Jobs\Assets\ImportJob;
use App\Jobs\Masters\Category\BulkJob as CategoryBulkJob;
use App\Jobs\Masters\Cluster\BulkJob as ClusterBulkJob;
use App\Jobs\Masters\Leasing\BulkJob as LeasingBulkJob;
use App\Jobs\Masters\SubCluster\BulkJob as SubClusterBulkJob;
use App\Models\Assets\Asset;
use App\Models\Assets\AssetLeasing;
use App\Models\Assets\Depreciation;
use App\Repositories\Assets\AssetInsuranceRepository;
use App\Repositories\Assets\AssetLeasingRepository;
use App\Repositories\Assets\AssetRepository;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AssetService
{
    public function __construct(
        protected AssetRepository $assetRepository,
        protected AssetInsuranceRepository $assetInsuranceRepository,
        protected AssetLeasingRepository $assetLeasingRepository,
        protected AssetUnitService $assetUnitService,
        protected AssetDepreciationService $assetDepreciationService,
    ) {
    }

    public function allNotElastic()
    {
        return Asset::query()->with(['assetUnit.unit', 'leasing', 'insurance', 'project'])->get();
    }

    public function all($search = null, $size = 50)
    {
        return Elasticsearch::setModel(Asset::class)->searchMultiMatch($search, $size)->all();
    }

    public function getById($id)
    {
        return Asset::query()->with([
            'assetUnit.unit',
            'subCluster',
            'insurance',
            'leasing',
            'uom',
        ])->find($id);
    }

    public function getByKode($kode)
    {
        return Asset::query()
            ->with(['assetUnit.unit', 'subCluster', 'insurance', 'leasing.dealer', 'leasing.leasing', 'uom'])
            ->where('kode', $kode)
            ->firstOrFail();
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
        DB::transaction(function () use ($request) {
            $assetUnit = $this->assetUnitService->updateOrCreate(AssetUnitData::fromRequest($request));
            $data = AssetData::from(array_merge($request->all(), ['asset_unit_id' => $assetUnit->getKey()]));
            $asset = $this->assetRepository->updateOrCreate($data->except('new_id_asset'));
            $deprecations = $this->prepareDeprecation($asset->getKey(), $request->umur_asset, Helper::resetRupiah($request->price), $request->date);
            $asset->depreciations()->delete();
            $asset->depreciations()->createMany($deprecations);
            $this->assetInsuranceRepository->updateOrCreateByAsset(AssetInsuranceData::fromRequest($request), $asset);
            $this->assetLeasingRepository->updateOrCreateByAsset(AssetLeasingData::fromRequest($request), $asset);
            $this->sendToElasticsearch($asset, $data->getKey());
        });
    }

    public function prepareDeprecation($assetId, $month, $price, $date)
    {
        $depre = $this->assetDepreciationService->generate($month, $price, $date);
        $results = [];
        foreach ($depre as $key => $value) {
            $results[] = [
                'asset_id' => $assetId,
                'masa_pakai' => null,
                'umur_asset' => $month,
                'umur_pakai' => null,
                'depresiasi' => Helper::resetRupiah($value['depreciation']),
                'sisa' => Helper::resetRupiah($value['sisa']),
            ];
        }
        return $results;
    }

    public static function store(array $data)
    {
        if (!isset($data['kode'])) {
            return null;
        }

        $asset = Asset::query()->where('kode', $data['kode'])->first();
        if ($asset) {
            return $asset;
        }

        return Asset::query()->create([
            'kode' => $data['kode'],
            'asset_unit_id' => $data['asset_unit_id'],
            'sub_cluster_id' => $data['sub_cluster_id'],
            'pic' => $data['pic'],
            'activity' => $data['activity'],
            'asset_location' => $data['asset_location'],
            'dept_id' => $data['dept_id'],
            'kondisi' => $data['kondisi'],
            'uom_id' => $data['uom_id'],
            'quantity' => $data['quantity'],
            'umur_asset' => $data['umur_asset'],
            'tgl_bast' => $data['tgl_bast'],
            'hm' => $data['hm'],
            'pr_number' => $data['pr_number'],
            'po_number' => $data['po_number'],
            'gr_number' => $data['gr_number'],
            'remark' => $data['remark'],
            'status_asset' => $data['status_asset'],
        ]);
    }

    public function delete(Asset $asset)
    {
        return DB::transaction(function () use ($asset) {
            $this->assetUnitService->delete($asset->assetUnit);
            $this->assetInsuranceRepository->delete($asset->insurance);
            $this->assetLeasingRepository->delete($asset->leasing);
            Elasticsearch::setModel(Asset::class)->deleted(AssetData::from($asset));
            return $asset->delete();
        });
    }

    public function import(array $data)
    {
        Asset::truncate();
        AssetLeasing::truncate();
        Depreciation::truncate();
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
        $batch = CategoryService::instanceBulk($batch);
        $batch = ClusterService::instanceBulk($batch);
        $batch = LeasingService::instanceBulk($batch);
        $batch = SubClusterService::instanceBulk($batch);
        $batch = UnitService::instanceBulk($batch);
        $batch = UomService::instanceBulk($batch);
        return $batch;
    }

    public static function bulk(array $assets = [])
    {
        $assets = count($assets) > 0 ? $assets : self::getDataBulk();
        Elasticsearch::setModel(Asset::class)->bulk(AssetData::collection($assets));
    }

    private static function getDataBulk()
    {
        return Asset::query()->with(['assetUnit.unit', 'subCluster', 'depreciations', 'depreciation', 'insurance', 'leasing', 'uom', 'project', 'department'])->get();
    }

    private function sendToElasticsearch(Asset $asset, $key)
    {
        $asset->load(['assetUnit.unit', 'subCluster', 'depreciations', 'depreciation', 'insurance', 'leasing', 'uom']);
        if ($key) {
            return Elasticsearch::setModel(Asset::class)->updated(AssetData::from($asset));
        }
        return Elasticsearch::setModel(Asset::class)->created(AssetData::from($asset));
    }

    public function nextKode(string $kode)
    {
        $arr = str($kode)->explode('-');
        $arr->pop();
        $arr = $arr->replace([
            1 => '%'
        ]);
        $result = $arr->implode('-');
        $asset = Asset::query()
            ->select(['kode'])
            ->where('kode', 'like', "$result-%")
            ->orderBy('kode', 'DESC')
            ->first();

        $arr = str($asset?->kode)->explode('-');
        $num = (int) $arr->last();
        $num = $num + 1;
        $arr->pop();
        $arr->push($num);
        return $arr->implode('-');
    }
}
