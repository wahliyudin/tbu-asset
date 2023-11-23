<?php

namespace App\Http\Controllers\Reports;

use App\Exports\Reports\Cer\CerExport;
use App\Helpers\CarbonHelper;
use App\Http\Controllers\Controller;
use App\Services\Cers\CerService;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class CerController extends Controller
{
    public function __construct(
        protected CerService $cerService
    ) {
    }

    public function index()
    {
        return view('reports.cers.cer.index');
    }

    public function datatable(Request $request)
    {
        $data = $this->cerService->dataForExport($request);
        return datatables()->of($data)
            ->editColumn('no_cer', function ($data) {
                return $data->no_cer;
            })
            ->editColumn('employee', function ($data) {
                return $data->employee?->nama_karyawan;
            })
            ->editColumn('type_budget', function ($data) {
                return $data->type_budget?->badge();
            })
            ->editColumn('department', function ($data) {
                return $data->department?->department_name;
            })
            ->editColumn('budget_ref', function ($data) {
                return $data->budget_ref;
            })
            ->editColumn('peruntukan', function ($data) {
                return $data->peruntukan?->badge();
            })
            ->editColumn('tgl_kebutuhan', function ($data) {
                return CarbonHelper::dateFormatdFY($data->tgl_kebutuhan);
            })
            ->editColumn('justifikasi', function ($data) {
                return $data->justifikasi;
            })
            ->editColumn('sumber_pendanaan', function ($data) {
                return $data->sumber_pendanaan?->badge();
            })
            ->editColumn('cost_analyst', function ($data) {
                return $data->cost_analyst;
            })
            ->editColumn('note', function ($data) {
                return $data->note;
            })
            ->editColumn('file_ucr', function ($data) {
                return asset('storage/' . $data->file_ucr);
            })
            ->editColumn('status_pr', function ($data) {
                return $data->status_pr;
            })
            ->editColumn('status', function ($data) {
                return $data->status?->badge();
            })
            ->rawColumns(['status', 'type_budget', 'peruntukan', 'sumber_pendanaan', 'status_pr', 'cost_analyst'])
            ->make();
    }

    public function export(Request $request)
    {
        $cers = $this->cerService->dataForExport($request);
        return Excel::download(new CerExport($cers), 'cers.xlsx');
    }
}
