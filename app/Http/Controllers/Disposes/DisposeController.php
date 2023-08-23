<?php

namespace App\Http\Controllers\Disposes;

use App\DataTransferObjects\API\HRIS\EmployeeData;
use App\DataTransferObjects\Disposes\AssetDisposeData;
use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Disposes\AssetDisposeRequest;
use App\Models\Assets\Asset;
use App\Models\Disposes\AssetDispose;
use App\Services\API\HRIS\EmployeeService;
use App\Services\Assets\AssetService;
use App\Services\Disposes\AssetDisposeService;
use App\Services\GlobalService;
use Yajra\DataTables\Facades\DataTables;

class DisposeController extends Controller
{
    public function __construct(
        private AssetDisposeService $service,
        private EmployeeService $employeeService,
        private AssetService $assetService,
    ) {
    }

    public function index()
    {
        return view('disposes.dispose.index');
    }

    public function datatable()
    {
        return DataTables::of($this->service->all())
            ->editColumn('no_dispose', function (AssetDispose $assetDispose) {
                return $assetDispose->no_dispose;
            })
            ->editColumn('pelaksanaan', function (AssetDispose $assetDispose) {
                return $assetDispose->pelaksanaan->badge();
            })
            ->editColumn('nilai_buku', function (AssetDispose $assetDispose) {
                return Helper::formatRupiah($assetDispose->nilai_buku, true);
            })
            ->editColumn('est_harga_pasar', function (AssetDispose $assetDispose) {
                return Helper::formatRupiah($assetDispose->est_harga_pasar, true);
            })
            ->editColumn('status', function (AssetDispose $assetDispose) {
                return $assetDispose->status->badge();
            })
            ->editColumn('action', function (AssetDispose $assetDispose) {
                return view('disposes.dispose.action', compact('assetDispose'))->render();
            })
            ->rawColumns(['action', 'pelaksanaan', 'status'])
            ->make();
    }

    public function datatableAsset()
    {
        return DataTables::of($this->assetService->all())
            ->editColumn('description', function (Asset $asset) {
                return $asset->unit?->spesification;
            })
            ->editColumn('model_spesification', function (Asset $asset) {
                return $asset->unit?->model;
            })
            ->editColumn('serial_no', function (Asset $asset) {
                return $asset->unit?->serial_number;
            })
            ->editColumn('no_asset', function (Asset $asset) {
                return $asset->kode;
            })
            ->editColumn('tahun_buat', function (Asset $asset) {
                return $asset->unit?->tahun_pembuatan;
            })
            ->editColumn('nilai_buku', function (Asset $asset) {
                return Helper::formatRupiah($asset->leasing?->harga_beli);
            })
            ->editColumn('action', function (Asset $asset) {
                return '<button type="button" data-asset="' . $asset->getKey() . '" class="btn btn-sm btn-primary select-asset">select</button>';
            })
            ->rawColumns(['action'])
            ->make();
    }

    public function show(AssetDispose $assetDispose)
    {
        $assetDispose->load(['asset.unit']);
        $data = AssetDisposeData::from($assetDispose);
        return view('disposes.dispose.show', [
            'assetDispose' => $data,
            'employee' => $data->employee,
        ]);
    }

    public function create()
    {
        return view('disposes.dispose.create', [
            'employee' => EmployeeData::from(GlobalService::getEmployee(null, true))
        ]);
    }

    public function store(AssetDisposeRequest $request)
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

    public function edit(AssetDispose $assetDispose)
    {
        try {
            $assetDispose->loadMissing(['asset.unit']);
            $data = AssetDisposeData::from($assetDispose);
            return view('disposes.dispose.edit', [
                'assetDispose' => $data,
                'employee' => $data->employee,
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function destroy(AssetDispose $assetDispose)
    {
        try {
            $this->service->delete($assetDispose);
            return response()->json([
                'message' => 'Berhasil dihapus'
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
