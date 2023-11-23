<?php

namespace App\Http\Controllers\Reports;

use App\Exports\Reports\AssetTransfer\TransferExport;
use App\Helpers\CarbonHelper;
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
            ->editColumn('no_transaksi', function ($data) {
                return $data->no_transaksi;
            })
            ->editColumn('nik', function ($data) {
                return $data->nik;
            })
            ->editColumn('asset_id', function ($data) {
                return $data->asset_id;
            })
            ->editColumn('old_project', function ($data) {
                return $data->old_project;
            })
            ->editColumn('old_pic', function ($data) {
                return $data->old_pic;
            })
            ->editColumn('old_location', function ($data) {
                return $data->old_location;
            })
            ->editColumn('old_divisi', function ($data) {
                return $data->old_divisi;
            })
            ->editColumn('old_department', function ($data) {
                return $data->old_department;
            })
            ->editColumn('new_project', function ($data) {
                return $data->new_project;
            })
            ->editColumn('new_pic', function ($data) {
                return $data->new_pic;
            })
            ->editColumn('new_location', function ($data) {
                return $data->new_location;
            })
            ->editColumn('new_divisi', function ($data) {
                return $data->new_divisi;
            })
            ->editColumn('new_department', function ($data) {
                return $data->new_department;
            })
            ->editColumn('request_transfer_date', function ($data) {
                return CarbonHelper::dateFormatdFY($data->request_transfer_date);
            })
            ->editColumn('justifikasi', function ($data) {
                return $data->justifikasi;
            })
            ->editColumn('remark', function ($data) {
                return $data->remark;
            })
            ->editColumn('note', function ($data) {
                return $data->note;
            })
            ->editColumn('transfer_date', function ($data) {
                return CarbonHelper::dateFormatdFY($data->transfer_date);
            })
            ->editColumn('tanggal_bast', function ($data) {
                return CarbonHelper::dateFormatdFY($data->tanggal_bast);
            })
            ->editColumn('no_bast', function ($data) {
                return $data->no_bast;
            })
            ->editColumn('file_bast', function ($data) {
                return $data->file_bast;
            })
            ->editColumn('status', function ($data) {
                return $data->status?->badge();
            })
            ->rawColumns(['status', 'justifikasi'])
            ->make();
    }

    public function export(Request $request)
    {
        $assetTransfers = $this->assetTransferService->dataForExport($request);
        return Excel::download(new TransferExport($assetTransfers), 'asset-transfers.xlsx');
    }
}
