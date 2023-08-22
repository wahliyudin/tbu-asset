<?php

namespace App\Http\Controllers\Assets;

use App\Http\Controllers\Controller;
use App\Http\Requests\Assets\AssetRequest;
use App\Models\Assets\Asset;
use App\Services\Assets\AssetService;
use App\Services\GlobalService;
use App\Services\Masters\DealerService;
use App\Services\Masters\LeasingService;
use App\Services\Masters\SubClusterService;
use App\Services\Masters\UnitService;
use Yajra\DataTables\Facades\DataTables;

class AssetMasterController extends Controller
{
    public function __construct(
        private AssetService $service,
    ) {
    }

    public function index()
    {
        return view('assets.asset.index', [
            'units' => UnitService::dataForSelect(),
            'subClusters' => SubClusterService::dataForSelect(),
            'dealers' => DealerService::dataForSelect(),
            'leasings' => LeasingService::dataForSelect(),
            'employees' => GlobalService::getEmployees(['nik', 'nama_karyawan'])
        ]);
    }

    public function datatable()
    {
        return DataTables::of($this->service->all())
            ->editColumn('kode', function (Asset $asset) {
                return $asset->kode;
            })
            ->editColumn('kode_unit', function (Asset $asset) {
                return $asset->unit?->kode;
            })
            ->editColumn('unit_model', function (Asset $asset) {
                return $asset->unit?->model;
            })
            ->editColumn('unit_type', function (Asset $asset) {
                return $asset->unit?->type;
            })
            ->editColumn('asset_location', function (Asset $asset) {
                return $asset->asset_location;
            })
            ->editColumn('pic', function (Asset $asset) {
                return $asset->pic;
            })
            ->editColumn('action', function (Asset $asset) {
                return view('assets.asset.action', compact('asset'))->render();
            })
            ->rawColumns(['action'])
            ->make();
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

    public function edit(Asset $asset)
    {
        try {
            return response()->json($this->service->getDataForEdit($asset));
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
}
