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
            ->editColumn('asset_id', function ($data) {
                return $data->asset_id;
            })
            ->editColumn('no_dispose', function ($data) {
                return $data->no_dispose;
            })
            ->editColumn('nik', function ($data) {
                return $data->nik;
            })
            ->editColumn('nilai_buku', function ($data) {
                return $data->nilai_buku;
            })
            ->editColumn('est_harga_pasar', function ($data) {
                return $data->est_harga_pasar;
            })
            ->editColumn('notes', function ($data) {
                return $data->notes;
            })
            ->editColumn('justifikasi', function ($data) {
                return $data->justifikasi;
            })
            ->editColumn('pelaksanaan', function ($data) {
                return $data->pelaksanaan;
            })
            ->editColumn('remark', function ($data) {
                return $data->remark;
            })
            ->editColumn('note', function ($data) {
                return $data->note;
            })
            ->editColumn('status', function ($data) {
                return $data->status;
            })
            ->rawColumns(['status', 'justifikasi'])
            ->make();
    }

    public function export(Request $request)
    {
        $data = $this->assetDisposeService->dataForExport($request);
        return Excel::download(new DisposeExport($data), 'asset-disposes.xlsx');
    }
}
