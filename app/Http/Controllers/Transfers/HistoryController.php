<?php

namespace App\Http\Controllers\Transfers;

use App\Http\Controllers\Controller;
use App\Services\Assets\AssetService;

class HistoryController extends Controller
{
    public function __construct(
        protected AssetService $assetService
    ) {
    }

    public function index()
    {
        return view('transfers.history.index');
    }

    public function datatable()
    {
        return datatables()->of($this->assetService->assetWithExistTransfers())
            ->editColumn('id_asset', function ($asset) {
                return $asset->kode;
            })
            ->editColumn('model', function ($asset) {
                return $asset->assetUnit?->unit?->model;
            })
            ->editColumn('type', function ($asset) {
                return $asset->assetUnit?->type;
            })
            ->editColumn('pic', function ($asset) {
                return $asset->employee?->nama_karyawan;
            })
            ->editColumn('action', function ($asset) {
                return view('transfers.history.action', compact('asset'))->render();
            })
            ->rawColumns(['action'])
            ->make();
    }

    public function detail($id)
    {
        return view('transfers.history.show', [
            'asset' => $this->assetService->assetWithTransferById($id)
        ]);
    }

    public function show($id)
    {
        try {
            $asset = $this->assetService->assetWithTransferById($id);
            return response()->json($asset->transfers);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
