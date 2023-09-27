<?php

namespace App\Http\Controllers\Approval;

use App\DataTransferObjects\Cers\CerData;
use App\Enums\Workflows\LastAction;
use App\Http\Controllers\Controller;
use App\Models\Cers\Cer;
use App\Services\API\HRIS\EmployeeService;
use App\Services\Cers\CerService;
use App\Services\Cers\CerWorkflowService;
use Yajra\DataTables\Facades\DataTables;

class ApprovalCerController extends Controller
{
    public function __construct(
        private CerService $service,
        private EmployeeService $employeeService,
    ) {
    }

    public function index()
    {
        return view('approvals.cer.index');
    }

    public function datatable()
    {
        return DataTables::of(CerService::getByCurrentApproval())
            ->editColumn('no_cer', function (Cer $cer) {
                return $cer->no_cer;
            })
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
                return view('approvals.cer.action', compact('cer'))->render();
            })
            ->rawColumns(['action', 'type_budget', 'peruntukan', 'sumber_pendanaan', 'status',])
            ->make();
    }

    public function show(Cer $cer)
    {
        $isCurrentWorkflow = CerWorkflowService::setModel($cer)->isCurrentWorkflow();
        $cer->load(['employee.position.department', 'employee.position.project', 'department', 'items.uom', 'workflows' => function ($query) {
            $query->orderBy('sequence', 'ASC');
        }]);
        $data = CerData::from($cer);
        return view('approvals.cer.show', [
            'cer' => $data,
            'employee' => $data->employee,
            'isCurrentWorkflow' => $isCurrentWorkflow,
        ]);
    }

    public function approv(Cer $cer)
    {
        try {
            CerWorkflowService::setModel($cer)->lastAction(LastAction::APPROV);
            return response()->json([
                'message' => 'Berhasil Diverifikasi.'
            ]);
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function reject(Cer $cer)
    {
        try {
            CerWorkflowService::setModel($cer)->lastAction(LastAction::REJECT);
            return response()->json([
                'message' => 'Berhasil Direject.'
            ]);
        } catch (\Throwable $e) {
            throw $e;
        }
    }
}
