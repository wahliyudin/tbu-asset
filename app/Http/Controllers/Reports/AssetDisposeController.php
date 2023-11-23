<?php

namespace App\Http\Controllers\Reports;

use App\Exports\Reports\AssetDispose\DisposeExport;
use App\Http\Controllers\Controller;
use App\Services\Disposes\AssetDisposeService;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class AssetDisposeController extends Controller
{
    public function __construct(
        protected AssetDisposeService $assetDisposeService
    ) {
    }

    public function index()
    {
        return view('reports.asset-dispose.index');
    }

    public function datatable(Request $request)
    {
        $data = $this->assetDisposeService->dataForExport($request);
        return datatables()->of($data)
            ->editColumn('kode', function ($asset) {
                return $asset->kode;
            })
            ->rawColumns(['status'])
            ->make();
    }

    public function export(Request $request)
    {
        $data = $this->assetDisposeService->dataForExport($request);
        return Excel::download(new DisposeExport($data), 'asset-disposes.xlsx');
    }
}
