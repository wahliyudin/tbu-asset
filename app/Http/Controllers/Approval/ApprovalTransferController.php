<?php

namespace App\Http\Controllers\Approval;

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
        return DataTables::of($this->service->all())
            ->editColumn('name', function (AssetTransfer $assetTransfer) {
                return 'example';
            })
            ->editColumn('action', function (AssetTransfer $assetTransfer) {
                return view('approvals.transfer.action', compact('assetTransfer'))->render();
            })
            ->rawColumns(['action'])
            ->make();
    }

    public function show()
    {
        return view('approvals.transfer.show');
    }
}