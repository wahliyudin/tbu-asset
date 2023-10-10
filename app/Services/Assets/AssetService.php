<?php

namespace App\Services\Assets;

use App\DataTransferObjects\Assets\AssetData;
use App\DataTransferObjects\Assets\AssetInsuranceData;
use App\DataTransferObjects\Assets\AssetLeasingData;
use App\DataTransferObjects\Assets\AssetUnitData;
use App\Enums\Asset\Status;
use App\Enums\Transfers\Transfer\Status as TransferStatus;
use App\Facades\Elasticsearch;
use App\Facades\Masters\Category\CategoryService;
use App\Facades\Masters\Cluster\ClusterService;
use App\Facades\Masters\Leasing\LeasingService;
use App\Facades\Masters\SubCluster\SubClusterService;
use App\Facades\Masters\Unit\UnitService;
use App\Facades\Masters\Uom\UomService;
use App\Helpers\Helper;
use App\Http\Requests\Assets\AssetRequest;
use App\Jobs\Assets\BulkCompleted;
use App\Jobs\Assets\BulkJob;
use App\Jobs\Assets\ImportCompleted;
use App\Jobs\Assets\ImportJob;
use App\Jobs\Masters\Category\BulkJob as CategoryBulkJob;
use App\Jobs\Masters\Cluster\BulkJob as ClusterBulkJob;
use App\Jobs\Masters\Leasing\BulkJob as LeasingBulkJob;
use App\Jobs\Masters\SubCluster\BulkJob as SubClusterBulkJob;
use App\Models\Assets\Asset;
use App\Models\Assets\AssetLeasing;
use App\Models\Assets\Depreciation;
use App\Models\Masters\Lifetime;
use App\Models\Masters\Unit;
use App\Repositories\Assets\AssetInsuranceRepository;
use App\Repositories\Assets\AssetLeasingRepository;
use App\Repositories\Assets\AssetRepository;
use Illuminate\Bus\Batch;
use Illuminate\Http\Request;
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
            'subCluster.cluster.category', 'department',
            'insurance',
            'leasing',
            'uom', 'lifetime', 'activity', 'condition'
        ])->find($id);
    }

    public function getByKode($kode)
    {
        return Asset::query()
            ->with(['assetUnit.unit', 'subCluster.cluster.category', 'department', 'insurance', 'leasing.dealer', 'leasing.leasing', 'uom', 'lifetime', 'activity', 'condition'])
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
            $nilaiSisa = Helper::resetRupiah($request->nilai_sisa);
            $data = AssetData::from(array_merge($request->all(), ['asset_unit_id' => $assetUnit->getKey(), 'nilai_sisa' => $nilaiSisa]));
            $asset = $this->assetRepository->updateOrCreate($data->except('new_id_asset'));
            $lifetime = Lifetime::query()->find($request->lifetime_id);
            $deprecations = $this->prepareDeprecation($asset->getKey(), $lifetime->masa_pakai, $request->date, Helper::resetRupiah($request->price));
            $asset->depreciations()->delete();
            $asset->depreciations()->createMany($deprecations);
            $this->assetInsuranceRepository->updateOrCreateByAsset(AssetInsuranceData::fromRequest($request), $asset);
            $this->assetLeasingRepository->updateOrCreateByAsset(AssetLeasingData::fromRequest($request), $asset);
            $this->sendToElasticsearch($asset, $data->getKey());
        });
    }

    public function prepareDepreciationFromResult(array $depre, $assetId, $masa_pakai)
    {
        $results = [];
        foreach (isset($depre['result']) ? $depre['result'] : [] as $key => $value) {
            $results[] = [
                'asset_id' => $assetId,
                'masa_pakai' => $masa_pakai,
                'umur_asset' => null,
                'umur_pakai' => null,
                'depresiasi' => Helper::resetRupiah($value['depreciation']),
                'sisa' => Helper::resetRupiah($value['sisa']),
            ];
        }
        return $results;
    }

    public function prepareDeprecation($assetId, $masa_pakai, $date, $price)
    {
        $depre = $this->assetDepreciationService->generate($masa_pakai, $date, $price);
        $results = [];
        foreach ($depre['result'] as $key => $value) {
            $results[] = [
                'asset_id' => $assetId,
                'masa_pakai' => $masa_pakai,
                'umur_asset' => null,
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
            'activity_id' => $data['activity_id'],
            'asset_location' => $data['asset_location'],
            'dept_id' => $data['dept_id'],
            'condition_id' => $data['condition_id'],
            'lifetime_id' => $data['lifetime_id'],
            'uom_id' => $data['uom_id'],
            'quantity' => $data['quantity'],
            'nilai_sisa' => $data['nilai_sisa'],
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
        dispatch(new ImportCompleted($batch->id));
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
        dispatch(new BulkCompleted($batch->id));
        return $batch;
    }

    public static function bulk(array $assets = [])
    {
        $assets = count($assets) > 0 ? $assets : self::getDataBulk();
        Elasticsearch::setModel(Asset::class)->bulk(AssetData::collection($assets));
    }

    private static function getDataBulk()
    {
        return Asset::query()->with(['assetUnit.unit', 'subCluster.cluster.category', 'department', 'depreciations', 'depreciation', 'insurance', 'leasing', 'uom', 'lifetime', 'activity', 'condition', 'project', 'department'])->get();
    }

    public function nextIdAssetUnitById($id)
    {
        $assetUnit = $this->assetUnitService->getByIdAndLatest($id);
        $unit = Unit::query()->find($id);
        $lastKode = $assetUnit?->kode;
        $prefix = $unit->prefix . '-';
        $length = 6;
        $prefixLength = strlen($unit->prefix);
        $idLength = $length - $prefixLength;
        if (!$lastKode) {
            return $prefix . str_pad(1, $idLength, '0', STR_PAD_LEFT);
        }
        $maxId = substr($lastKode, $prefixLength + 1, $idLength);
        return $prefix . str_pad((int)$maxId + 1, $idLength, '0', STR_PAD_LEFT);
    }

    private function sendToElasticsearch(Asset $asset, $key)
    {
        $asset->load(['assetUnit.unit', 'subCluster.cluster.category', 'department', 'depreciations', 'depreciation', 'insurance', 'leasing', 'uom', 'lifetime', 'activity', 'condition', 'employee']);
        if ($key) {
            return Elasticsearch::setModel(Asset::class)->updated(AssetData::from($asset));
        }
        return Elasticsearch::setModel(Asset::class)->created(AssetData::from($asset));
    }

    public function nextKode(string $kode)
    {
        $arr = str($kode)->explode('-');
        $arr->pop();
        $tmp = $arr->replace([
            1 => '%'
        ]);
        $result = $tmp->implode('-');
        $asset = Asset::query()
            ->select(['kode'])
            ->where('kode', 'like', "$result-%")
            ->orderBy('kode', 'DESC')
            ->first();
        if (!$asset) {
            $arr->push('0001');
            return $arr->implode('-');
        }

        $arr = str($asset?->kode)->explode('-');
        $num = (int) $arr->last();
        $num = $num + 1;
        $arr->pop();
        $arr->push($num);
        return $arr->implode('-');
    }

    public function dataForExport(Request $request)
    {
        $matchs = [];
        $terms = [];
        $search  = isset($request->search['value']) ? $request->search['value'] : null;
        if ($status = $request->status) {
            $terms['status'] = $status;
        }
        if ($project = $request->project) {
            $terms['asset_location'] = $project;
        }
        if ($category = $request->category) {
            $terms['sub_cluster.cluster.category_id'] = $category;
        }
        if ($cluster = $request->cluster) {
            $terms['sub_cluster.cluster_id'] = $cluster;
        }
        if ($sub_cluster = $request->sub_cluster) {
            $terms['sub_cluster_id'] = $sub_cluster;
        }
        return Elasticsearch::setModel(Asset::class)
            ->searchMultipleQuery($search, $matchs, $terms, 1000)->all();
    }

    public function assetWithExistTransfers()
    {
        return Asset::query()->with(['assetUnit.unit', 'employee'])
            ->withWhereHas('transfers', function ($query) {
                $query->whereHas('statusTransfer', function ($query) {
                    $query->where('status', TransferStatus::RECEIVED);
                });
            })->get();
    }

    public function assetWithTransferById($id)
    {
        return Asset::query()->with(['assetUnit.unit', 'employee'])
            ->withWhereHas('transfers', function ($query) {
                $query->with(['oldPic', 'newPic'])->whereHas('statusTransfer', function ($query) {
                    $query->where('status', TransferStatus::RECEIVED);
                })->latest();
            })->findOrFail($id);
    }
}
