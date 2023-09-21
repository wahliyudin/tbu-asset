<?php

namespace App\Http\Controllers\Assets;

use App\DataTransferObjects\Assets\AssetData;
use App\Excels\Assets\Asset as AssetsAsset;
use App\Helpers\CarbonHelper;
use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Assets\AssetRequest;
use App\Http\Requests\Assets\ImportRequest;
use App\Imports\Assets\AssetImport;
use App\Models\Assets\Asset;
use App\Models\Masters\Lifetime;
use App\Services\Assets\AssetDepreciationService;
use App\Services\Assets\AssetService;
use App\Services\GlobalService;
use App\Services\Masters\ActivityService;
use App\Services\Masters\ConditionService;
use App\Services\Masters\LeasingService;
use App\Services\Masters\LifetimeService;
use App\Services\Masters\SubClusterService;
use App\Services\Masters\UnitService;
use App\Services\Masters\UomService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Bus;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class AssetMasterController extends Controller
{
    public function __construct(
        private AssetService $service,
        private AssetDepreciationService $assetDepreciationService,
    ) {
    }

    public function index()
    {
        // dd($this->service->allNotElastic()->first());
        return view('assets.asset.index', [
            'uoms' => UomService::dataForSelect(),
            'subClusters' => SubClusterService::dataForSelect(),
            'units' => UnitService::dataForSelect(),
            'lifetimes' => LifetimeService::dataForSelect(),
            'activities' => ActivityService::dataForSelect(),
            'conditions' => ConditionService::dataForSelect(),
            'dealers' => GlobalService::vendorForSelect(),
            'leasings' => LeasingService::dataForSelect(),
            'projects' => GlobalService::getProjects(),
            'employees' => GlobalService::getEmployees(['nik', 'nama_karyawan'])->toCollection()
        ]);
    }

    public function datatablePG(Request $request)
    {
        return DataTables::collection($this->service->allNotElastic())
            ->editColumn('kode', function ($asset) {
                return $asset->kode;
            })
            ->editColumn('kode_unit', function ($asset) {
                return $asset->assetUnit?->kode;
            })
            ->editColumn('unit_model', function ($asset) {
                return $asset->assetUnit?->unit?->model;
            })
            ->editColumn('unit_type', function ($asset) {
                return $asset->assetUnit?->type;
            })
            ->editColumn('asset_location', function ($asset) {
                return $asset->project?->project;
            })
            ->editColumn('pic', function ($asset) {
                return $asset->employee?->nama_karyawan ?? $asset->pic;
            })
            ->editColumn('action', function ($asset) {
                $key = $asset->getKey();
                $kode = $asset->kode;
                return view('assets.asset.action', compact('key', 'kode'))->render();
            })
            ->rawColumns(['action'])
            ->make();
    }


    public function datatable(Request $request)
    {
        return DataTables::collection($this->service->all($request->get('search')))
            ->editColumn('kode', function ($asset) {
                return $asset->_source->kode;
            })
            ->editColumn('kode_unit', function ($asset) {
                return $asset->_source->asset_unit?->kode;
            })
            ->editColumn('unit_model', function ($asset) {
                return $asset->_source->asset_unit?->unit?->model;
            })
            ->editColumn('unit_type', function ($asset) {
                return $asset->_source->asset_unit?->type;
            })
            ->editColumn('asset_location', function ($asset) {
                return $asset->_source->project?->project;
            })
            ->editColumn('pic', function ($asset) {
                return $asset->_source->employee?->nama_karyawan ?? $asset->_source->pic;
            })
            ->editColumn('action', function ($asset) {
                $key = $asset->_source->id;
                $kode = $asset->_source->kode;
                return view('assets.asset.action', compact('key', 'kode'))->render();
            })
            ->rawColumns(['action'])
            ->make();
    }

    public function show($kode)
    {
        return view('assets.asset.show', [
            'asset' => AssetData::from($this->service->getByKode($kode)),
        ]);
    }

    public function showScan($kode)
    {
        return view('assets.asset.show-scan', [
            'asset' => AssetData::from($this->service->getByKode($kode)),
        ]);
    }

    public function store(AssetRequest $request)
    {
        try {
            $this->service->updateOrCreate($request);
            return response()->json([
                'message' => 'Berhasil disimpan'
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function edit($id)
    {
        try {
            return response()->json($this->service->getDataForEdit($id));
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function destroy(Asset $asset)
    {
        try {
            $this->service->delete($asset);
            return response()->json([
                'message' => 'Berhasil dihapus'
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function import(ImportRequest $request)
    {
        try {
            $results = Excel::toArray(new AssetImport, $request->file('file'));
            $batch = $this->service->import(isset($results[0]) ? $results[0] : []);
            return response()->json($batch);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function batch(Request $request)
    {
        try {
            $batch = Bus::findBatch($request->id);
            return $batch;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function bulk()
    {
        try {
            return $this->service->startBulk();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function format()
    {
        return response()->download((new AssetsAsset)->generate());
    }

    public function depreciation(Request $request)
    {
        try {
            $lifetime_id = $request->get('lifetime_id');
            $price = $request->get('price');
            $nilaiSisa = $request->get('nilai_sisa');
            $date = $request->get('date');
            if (!$lifetime_id || !$price || !$date) {
                return response()->json([]);
            }
            $request->validate([
                'date' => ['date'],
            ]);
            $lifetime = Lifetime::query()->find($lifetime_id);
            $depresiasi = $this->assetDepreciationService->generate($lifetime?->masa_pakai, CarbonHelper::convertDate($date), Helper::resetRupiah($price), Helper::resetRupiah($nilaiSisa));
            return response()->json($depresiasi);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function nextIdAssetUnit($id)
    {
        try {
            return response()->json([
                'id' => $this->service->nextIdAssetUnitById($id)
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
