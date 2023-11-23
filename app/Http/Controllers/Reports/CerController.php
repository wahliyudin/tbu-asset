<?php

namespace App\Http\Controllers\Reports;

use App\Exports\Reports\Cer\CerExport;
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
            ->editColumn('kode', function ($asset) {
                return $asset->kode;
            })
            ->rawColumns(['status'])
            ->make();
    }

    public function export(Request $request)
    {
        $cers = $this->cerService->dataForExport($request);
        return Excel::download(new CerExport($cers), 'cers.xlsx');
    }
}
