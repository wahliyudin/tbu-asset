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
use App\Models\Employee;
use App\Models\Masters\Lifetime;
use App\Models\Project;
use App\Services\Assets\AssetDepreciationService;
use App\Services\Assets\AssetService;
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
        return view('assets.asset.index');
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
        return datatables()
            ->eloquent($this->service->datatable($request))
            ->addColumn('kode_unit', function ($asset) {
                return $asset->assetUnit?->kode;
            })
            ->addColumn('unit_model', function ($asset) {
                return $asset->assetUnit?->unit?->model;
            })
            ->addColumn('unit_type', function ($asset) {
                return $asset->assetUnit?->type;
            })
            ->addColumn('asset_location', function ($asset) {
                return $asset->project?->project;
            })
            ->addColumn('employee', function ($asset) {
                return $asset->employee?->nama_karyawan ?? $asset->pic;
            })
            ->addColumn('action', function ($asset) {
                $key = $asset->id;
                $kode = $asset->kode;
                return view('assets.asset.action', compact('key', 'kode'))->render();
            })
            ->toJson();
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
            $date = $request->get('date');
            if (!$lifetime_id || !$price || !$date) {
                return response()->json([]);
            }
            $request->validate([
                'date' => ['date'],
            ]);
            $lifetime = Lifetime::query()->find($lifetime_id);
            $depresiasi = $this->assetDepreciationService->generate($lifetime?->masa_pakai, CarbonHelper::convertDate($date), Helper::resetRupiah($price));
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
