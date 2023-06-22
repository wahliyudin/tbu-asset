<?php

namespace App\Http\Controllers\Disposes;

use App\Http\Controllers\Controller;
use App\Http\Requests\Disposes\AssetDisposeRequest;
use App\Models\Disposes\AssetDispose;
use App\Services\Disposes\AssetDisposeService;
use Yajra\DataTables\Facades\DataTables;

class DisposeController extends Controller
{
    public function __construct(
        private AssetDisposeService $service
    ) {
    }

    public function index()
    {
        return view('disposes.dispose.index');
    }

    public function datatable()
    {
        return DataTables::of($this->service->all())
            ->editColumn('name', function (AssetDispose $assetDispose) {
                return 'example';
            })
            ->editColumn('action', function (AssetDispose $assetDispose) {
                return view('disposes.dispose.action', compact('assetDispose'))->render();
            })
            ->rawColumns(['action'])
            ->make();
    }

    public function create()
    {
        return view('disposes.dispose.create');
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
            return response()->json($assetDispose);
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