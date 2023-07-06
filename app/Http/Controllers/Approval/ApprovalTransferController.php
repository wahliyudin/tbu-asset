<?php

namespace App\Http\Controllers\Approval;

use App\DataTransferObjects\Transfers\AssetTransferData;
use App\Http\Controllers\Controller;
use App\Models\Transfers\AssetTransfer;
use App\Services\Transfers\AssetTransferService;
use Yajra\DataTables\Facades\DataTables;

class ApprovalTransferController extends Controller
{
    public function __construct(
        private AssetTransferService $service
    ) {
    }

    public function index()
    {
        return view('approvals.transfer.index');
    }

    public function datatable()
    {
        return DataTables::of($this->service->allToAssetTransferData())
            ->editColumn('no_transaksi', function (AssetTransferData $assetTransfer) {
                return $assetTransfer->no_transaksi;
            })
            ->editColumn('asset', function (AssetTransferData $assetTransfer) {
                return $assetTransfer->asset?->kode;
            })
            ->editColumn('old_pic', function (AssetTransferData $assetTransfer) {
                return $assetTransfer->oldPic?->nama_karyawan;
            })
            ->editColumn('new_pic', function (AssetTransferData $assetTransfer) {
                return $assetTransfer->newPic?->nama_karyawan;
            })
            ->editColumn('action', function (AssetTransferData $assetTransfer) {
                return view('approvals.transfer.action', compact('assetTransfer'))->render();
            })
            ->rawColumns(['action'])
            ->make();
    }

    public function show(AssetTransfer $assetTransfer)
    {
        $assetTransfer->loadMissing(['asset.unit', 'asset.leasing', 'workflows']);
        return view('approvals.transfer.show', [
            'assetTransfer' => AssetTransferData::from($assetTransfer)
        ]);
    }
}
