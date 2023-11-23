<?php

namespace App\Services\Assets;

use App\DataTransferObjects\Assets\AssetData;
use App\DataTransferObjects\Assets\AssetInsuranceData;
use App\DataTransferObjects\Assets\AssetLeasingData;
use App\DataTransferObjects\Assets\AssetUnitData;
use App\Elasticsearch\QueryBuilder\Term;
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
use App\Kafka\Enums\Nested;
use App\Kafka\Enums\Topic;
use App\Kafka\Facades\Message;
use App\Models\Assets\Asset;
use App\Models\Assets\AssetLeasing;
use App\Models\Assets\Depreciation;
use App\Models\Employee;
use App\Models\Masters\Lifetime;
use App\Models\Masters\Unit;
use App\Models\Project;
use App\Repositories\Assets\AssetInsuranceRepository;
use App\Repositories\Assets\AssetLeasingRepository;
use App\Repositories\Assets\AssetRepository;
use App\Repositories\Masters\UnitRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\DB;

class AssetService
{
    public function __construct(
        protected AssetRepository $assetRepository,
        protected AssetInsuranceRepository $assetInsuranceRepository,
        protected AssetLeasingRepository $assetLeasingRepository,
        protected AssetUnitService $assetUnitService,
        protected AssetDepreciationService $assetDepreciationService,
        protected UnitRepository $unitRepository,
    ) {
    }

    public function allNotElastic()
    {
        return $this->assetRepository->all();
    }

    public function all($search = null, $size = 50)
    {
        return Elasticsearch::setModel(Asset::class)->searchMultiMatch($search, $size)->all();
    }

    public function datatable(Request $request)
    {
        $searchTerm = $request->get('custom_search');
        $query = $this->assetRepository->instance();
        return $this->assetRepository->applySearchFilters($searchTerm, $query);
    }

    public function datatableForTransfers()
    {
        return Asset::query()->with([
            'assetUnit',
            'assetUnit.unit',
        ])->get();
    }

    public function assetIdle($search = null, $size = 50)
    {
        // return Elasticsearch::setModel(Asset::class)
        //     ->searchMultipleQuery($search, terms: [
        //         new Term('status', Status::IDLE->value)
        //     ], size: $size)
        //     ->all();
        return Asset::query()->with(['assetUnit', 'project', 'employee'])->where('status', Status::IDLE)->get();
    }

    public function getById($id)
    {
        return $this->assetRepository->findById($id);
    }

    public function getByKode($kode)
    {
        return $this->assetRepository->findByKode($kode);
    }

    public function getByStatus(Status $status)
    {
        return $this->assetRepository->getByStatus($status);
    }

    public function getDataForEdit($id): array
    {
        return $this->assetRepository->dataForEditById($id)?->toArray();
    }

    public function updateOrCreate(AssetRequest $request)
    {
        DB::transaction(function () use ($request) {
            $assetUnit = $this->assetUnitService->updateOrCreate(AssetUnitData::fromRequest($request));
            $nilaiSisa = Helper::resetRupiah($request->nilai_sisa);
            $data = AssetData::from(array_merge($request->all(), ['asset_unit_id' => $assetUnit->getKey(), 'nilai_sisa' => $nilaiSisa]));
            $asset = $this->assetRepository->updateOrCreate($data->except('new_id_asset'));
            $deprecations = $this->prepareDeprecation($asset->getKey(), $request->lifetime_id, $request->date, Helper::resetRupiah($request->price));
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
            $results[] = $this->populateDepreciation(
                $assetId,
                $masa_pakai,
                $value['depreciation'],
                $value['sisa']
            );
        }
        return $results;
    }

    public function populateDepreciation($assetId, $masaPakai, $depreciation, $sisa, $umurAsset = null, $umurPakai = null)
    {
        return [
            'asset_id' => $assetId,
            'masa_pakai' => $masaPakai,
            'umur_asset' => $umurAsset,
            'umur_pakai' => $umurPakai,
            'depresiasi' => Helper::resetRupiah($depreciation),
            'sisa' => Helper::resetRupiah($sisa),
        ];
    }

    public function prepareDeprecation($assetId, $masa_pakai, $date, $price)
    {
        $depre = $this->assetDepreciationService->generate($masa_pakai, $date, $price);
        $results = [];
        foreach ($depre['result'] as $key => $value) {
            $results[] = $this->populateDepreciation(
                $assetId,
                $masa_pakai,
                $value['depreciation'],
                $value['sisa']
            );
        }
        return $results;
    }

    public static function store(array $data)
    {
        if (!isset($data['kode'])) {
            return null;
        }
        $assetRepository = new AssetRepository;
        $asset = $assetRepository->findByKode($data['kode']);
        if ($asset) {
            return $asset;
        }

        return $assetRepository->insertByImport($data);
    }

    public function delete(Asset $asset)
    {
        return DB::transaction(function () use ($asset) {
            $this->assetUnitService->delete($asset->assetUnit);
            $this->assetInsuranceRepository->delete($asset->insurance);
            $this->assetLeasingRepository->delete($asset->leasing);
            Message::deleted(Topic::ASSET, 'id', $asset->getKey(), Nested::ASSET);
            return $asset->delete();
        });
    }

    public function import(array $data)
    {
        Asset::truncate();
        AssetLeasing::truncate();
        Depreciation::truncate();
        // Elasticsearch::setModel(Asset::class)->cleared();
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
        return (new AssetRepository)->getWithAllRelations();
    }

    public function nextIdAssetUnitById($id)
    {
        $assetUnit = $this->assetUnitService->getByIdAndLatest($id);
        $unit = $this->unitRepository->find($id);
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
        return Message::updateOrCreate(Topic::ASSET, $asset->getKey(), $asset->toArray());
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
        return Asset::query()
            ->with([
                'activity', 'project', 'department', 'condition', 'uom', 'lifetime', 'subCluster.cluster.category', 'employee', 'assetUnit'
            ])
            ->when($request->status, function ($query, $status) {
                $query->where('status', $status);
            })
            ->when($request->project, function ($query, $asset_location) {
                $query->where('asset_location', $asset_location);
            })
            ->when($request->category, function ($query, $category) {
                $query->whereHas('subCluster', function ($query) use ($category) {
                    $query->whereHas('cluster', function ($query) use ($category) {
                        $query->where('category_id', $category);
                    });
                });
            })
            ->when($request->cluster, function ($query, $cluster) {
                $query->whereHas('subCluster', function ($query) use ($cluster) {
                    $query->where('cluster_id', $cluster);
                });
            })
            ->when($request->sub_cluster, function ($query, $sub_cluster) {
                $query->where('sub_cluster_id', $sub_cluster);
            })
            ->get();
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

    public function transfer(Asset $asset, $toProject, $toPIC)
    {
        return DB::transaction(function () use ($asset, $toProject, $toPIC) {
            $asset->update([
                'asset_location' => $toProject,
                'pic' => $toPIC
            ]);
            $this->sendToElasticsearch($asset, $asset->getKey());
        });
    }
}
