<?php

namespace App\Http\Controllers\Assets;

use App\Enums\Asset\Status;
use App\Http\Controllers\Controller;
use App\Http\Requests\Assets\AssetRequest;
use App\Models\Assets\Asset;
use App\Models\Masters\Dealer;
use App\Models\Masters\Leasing;
use App\Models\Masters\SubCluster;
use App\Models\Masters\Unit;
use App\Services\Assets\AssetService;
use Yajra\DataTables\Contracts\DataTable;
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

    public function datatableAssetIdle()
    {
        return DataTables::of($this->service->getByStatus(Status::IDLE))
            ->editColumn('kode', function (Asset $asset) {
                return $asset->kode;
            })
            ->editColumn('asset_description', function (Asset $asset) {
                return $asset->unit?->spesification;
            })
            ->editColumn('asset_model', function (Asset $asset) {
                return $asset->unit?->model;
            })
            ->editColumn('umur_asset', function (Asset $asset) {
                return $asset->depreciation?->umur_asset;
            })
            ->editColumn('unit_price', function (Asset $asset) {
                return $asset->leasing?->harga_beli;
            })
            ->editColumn('action', function (Asset $asset) {
                return '<button type="button" data-asset="' . $asset->getKey() . '" class="btn btn-sm btn-primary select-asset">select</button>';
            })
            ->rawColumns(['action'])
            ->make();
    }
}