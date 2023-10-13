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
        return DataTables::collection($assetService->assetIdle($request->get('search')))
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
                return view('assets.idle.action', [
                    'kode' => $asset->_source->kode
                ])->render();
            })
            ->rawColumns(['action'])
            ->make();
    }
}
