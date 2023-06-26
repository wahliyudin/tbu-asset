<?php

namespace App\Http\Controllers\Approval;

use App\Http\Controllers\Controller;
use App\Models\Cers\Cer;
use App\Services\Cers\CerService;
use Yajra\DataTables\Facades\DataTables;

class ApprovalCerController extends Controller
{
    public function __construct(
        private CerService $service,
    ) {
    }

    public function index()
    {
        return view('approvals.cer.index');
    }

    public function datatable()
    {
        return DataTables::of($this->service->all())
            ->editColumn('type_budget', function (Cer $cer) {
                return $cer->type_budget->badge();
            })
            ->editColumn('budget_ref', function (Cer $cer) {
                return $cer->budget_ref;
            })
            ->editColumn('peruntukan', function (Cer $cer) {
                return $cer->peruntukan->badge();
            })
            ->editColumn('tgl_kebutuhan', function (Cer $cer) {
                return $cer->tgl_kebutuhan;
            })
            ->editColumn('sumber_pendanaan', function (Cer $cer) {
                return $cer->sumber_pendanaan->badge();
            })
            ->editColumn('status', function (Cer $cer) {
                return $cer->status->badge();
            })
            ->editColumn('action', function (Cer $cer) {
                return view('approvals.cers.action', compact('cer'))->render();
            })
            ->rawColumns(['action', 'type_budget', 'peruntukan', 'sumber_pendanaan', 'status',])
            ->make();
    }

    public function show(Cer $cer)
    {
        return view('approvals.cers.show', [
            'cer' => $cer
        ]);
    }
}
