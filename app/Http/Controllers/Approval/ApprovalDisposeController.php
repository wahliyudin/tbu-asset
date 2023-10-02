<?php

namespace App\Http\Controllers\Approval;

use App\DataTransferObjects\Disposes\AssetDisposeData;
use App\DataTransferObjects\Disposes\AssetDisposeDto;
use App\Enums\Workflows\LastAction;
use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Disposes\AssetDispose;
use App\Services\Disposes\AssetDisposeService;
use App\Services\Disposes\DisposeWorkflowService;
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
        return DataTables::of(AssetDisposeService::getByCurrentApproval())
            ->editColumn('no_dispose', function (AssetDispose $assetDispose) {
                return $assetDispose->no_dispose;
            })
            ->editColumn('pelaksanaan', function (AssetDispose $assetDispose) {
                return $assetDispose->pelaksanaan->badge();
            })
            ->editColumn('nilai_buku', function (AssetDispose $assetDispose) {
                return Helper::formatRupiah($assetDispose->nilai_buku);
            })
            ->editColumn('est_harga_pasar', function (AssetDispose $assetDispose) {
                return Helper::formatRupiah($assetDispose->est_harga_pasar);
            })
            ->editColumn('status', function (AssetDispose $assetDispose) {
                return $assetDispose->status->badge();
            })
            ->editColumn('action', function (AssetDispose $assetDispose) {
                return view('approvals.dispose.action', compact('assetDispose'))->render();
            })
            ->rawColumns(['action', 'pelaksanaan', 'status'])
            ->make();
    }

    public function show(AssetDispose $assetDispose)
    {
        $isCurrentWorkflow = DisposeWorkflowService::setModel($assetDispose)->isCurrentWorkflow();
        $assetDispose->load(['asset.unit', 'workflows' => function ($query) {
            $query->orderBy('sequence', 'ASC');
        }]);
        $data = AssetDisposeData::from($assetDispose);
        return view('approvals.dispose.show', [
            'assetDispose' => $data,
            'employee' => $data->employee,
            'isCurrentWorkflow' => $isCurrentWorkflow,
        ]);
    }

    public function approv(AssetDispose $assetDispose)
    {
        try {
            DisposeWorkflowService::setModel($assetDispose)->lastAction(LastAction::APPROV);
            return response()->json([
                'message' => 'Berhasil Diverifikasi.'
            ]);
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function reject(Request $request, AssetDispose $assetDispose)
    {
        try {
            DisposeWorkflowService::setModel($assetDispose)->lastAction(LastAction::REJECT, $request->note);
            return response()->json([
                'message' => 'Berhasil Direject.'
            ]);
        } catch (\Throwable $e) {
            throw $e;
        }
    }
}
