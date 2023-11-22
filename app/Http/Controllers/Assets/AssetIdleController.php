<?php

namespace App\Http\Controllers\Assets;

use App\Http\Controllers\Controller;
use App\Services\Assets\AssetService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AssetIdleController extends Controller
{
    public function index()
    {
        return view('assets.idle.index');
    }

    public function datatable(Request $request, AssetService $assetService)
    {
        return DataTables::collection($assetService->assetIdleNotElastic())
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
                return view('assets.idle.action', [
                    'kode' => $asset->kode
                ])->render();
            })
            ->rawColumns(['action'])
            ->make();
    }
}
