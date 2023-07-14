<?php

namespace App\Http\Controllers\Assets;

use App\DataTransferObjects\API\HRIS\EmployeeData;
use App\DataTransferObjects\Assets\AssetData;
use App\Facades\Elasticsearch;
use App\Http\Controllers\Controller;
use App\Http\Requests\Assets\AssetRequest;
use App\Models\Assets\Asset;
use App\Models\Masters\Dealer;
use App\Models\Masters\Leasing;
use App\Models\Masters\SubCluster;
use App\Models\Masters\Unit;
use App\Services\API\HRIS\EmployeeService;
use App\Services\Assets\AssetService;
use App\Services\GlobalService;
use Illuminate\Http\Request;
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
            'units' => Unit::query()->get(),
            'subClusters' => SubCluster::query()->get(),
            'dealers' => Dealer::query()->get(),
            'leasings' => Leasing::query()->get(),
            'employees' => GlobalService::getEmployees(['nik', 'nama_karyawan'])->toCollection()
        ]);
    }

    public function datatable(Request $request)
    {
        return DataTables::collection($this->service->all($request->get('search')))
            ->editColumn('kode', function ($asset) {
                return $asset->_source->kode;
            })
            ->editColumn('kode_unit', function ($asset) {
                return $asset->_source->unit?->kode;
            })
            ->editColumn('unit_model', function ($asset) {
                return $asset->_source->unit?->model;
            })
            ->editColumn('unit_type', function ($asset) {
                return $asset->_source->unit?->type;
            })
            ->editColumn('asset_location', function ($asset) {
                return $asset->_source->asset_location;
            })
            ->editColumn('pic', function ($asset) {
                return $asset->_source->employee?->nama_karyawan ?? $asset->_source->pic;
            })
            ->editColumn('action', function ($asset) {
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
}
