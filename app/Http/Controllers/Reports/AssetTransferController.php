<?php

namespace App\Http\Controllers\Reports;

use App\Exports\Reports\AssetTransfer\TransferExport;
use App\Http\Controllers\Controller;
use App\Services\Transfers\AssetTransferService;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class AssetTransferController extends Controller
{
    public function __construct(
        protected AssetTransferService $assetTransferService
    ) {
    }

    public function index()
    {
        return view('reports.asset-transfer.index');
    }

    public function datatable(Request $request)
    {
        $data = $this->assetTransferService->dataForExport($request);
        return datatables()->of($data)
            ->editColumn('kode', function ($asset) {
                return $asset->kode;
            })
            ->rawColumns(['status'])
            ->make();
    }

    public function export(Request $request)
    {
        $assetTransfers = $this->assetTransferService->dataForExport($request);
        return Excel::download(new TransferExport($assetTransfers), 'asset-transfers.xlsx');
    }
}
