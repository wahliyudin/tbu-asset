<?php

namespace App\Http\Controllers\Cers;

use App\DataTransferObjects\API\HRIS\EmployeeDto;
use App\DataTransferObjects\API\TXIS\BudgetDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Cers\CerRequest;
use App\Models\Cers\Cer;
use App\Services\API\HRIS\EmployeeService;
use App\Services\API\TXIS\BudgetService;
use App\Services\Cers\CerService;
use App\Services\Cers\CerWorkflowService;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class CerController extends Controller
{
    public function __construct(
        private CerService $service,
        private EmployeeService $employeeService,
        private BudgetService $budgetService,
    ) {
    }

    public function index()
    {
        return view('cers.cer.index');
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
                return view('cers.cer.action', compact('cer'))->render();
            })
            ->rawColumns(['action', 'type_budget', 'peruntukan', 'sumber_pendanaan', 'status',])
            ->make();
    }

    public function create()
    {
        $employee = EmployeeDto::fromResponse($this->employeeService->getByNik(Auth::user()->nik));
        return view('cers.cer.create', [
            'employee' => $employee
        ]);
    }

    public function store(CerRequest $request)
    {
        try {
            $this->service->updateOrCreate($request);
            return response()->json([
                'message' => 'Berhasil disimpan'
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function edit(Cer $cer)
    {
        try {
            return response()->json($cer);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function destroy(Cer $cer)
    {
        try {
            $this->service->delete($cer);
            return response()->json([
                'message' => 'Berhasil dihapus'
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
