<?php

namespace App\Http\Controllers\Approval;

use App\Http\Controllers\Controller;
use App\Models\Disposes\AssetDispose;
use App\Services\Disposes\AssetDisposeService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ApprovalDisposeController extends Controller
{
    public function __construct(
        private AssetDisposeService $service
    ) {
    }

    public function index()
    {
        return view('approvals.dispose.index');
    }

    public function datatable()
    {
        return DataTables::of($this->service->all())
            ->editColumn('name', function (AssetDispose $assetDispose) {
                return 'example';
            })
            ->editColumn('action', function (AssetDispose $assetDispose) {
                return view('approvals.dispose.action', compact('assetDispose'))->render();
            })
            ->rawColumns(['action'])
            ->make();
    }

    public function show()
    {
        return view('approvals.dispose.show');
    }
}