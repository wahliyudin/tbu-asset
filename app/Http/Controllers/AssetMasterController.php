<?php

namespace App\Http\Controllers;

use App\DataTransferObjects\AssetDto;
use App\Http\Requests\AssetRequest;
use App\Models\Asset;
use App\Models\SubCluster;
use App\Masters\Models\Unit;
use App\Services\AssetService;
use Yajra\DataTables\Facades\DataTables;

class AssetMasterController extends Controller
{
    public function __construct(
        private AssetService $service,
    ) {
    }

    public function index()
    {
        return view('asset.index', [
            'units' => Unit::query()->get(),
            'subClusters' => SubCluster::query()->get(),
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
                return view('asset.action', compact('asset'))->render();
            })
            ->rawColumns(['action'])
            ->make();
    }

    public function store(AssetRequest $request)
    {
        try {
            $this->service->updateOrCreate(AssetDto::fromRequest($request));
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
            return response()->json($asset);
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
