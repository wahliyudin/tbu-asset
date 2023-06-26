<?php

namespace App\Http\Controllers\ThirdParty\TXIS;

use App\DataTransferObjects\API\TXIS\BudgetDto;
use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Services\API\TXIS\BudgetService;
use Yajra\DataTables\Facades\DataTables;

class BudgetController extends Controller
{
    public function __construct(
        protected BudgetService $budgetService
    ) {
    }

    public function datatable()
    {
        return DataTables::of($this->budgetService->all())
            ->editColumn('kode', function (BudgetDto $budgetDto) {
                return $budgetDto->kode;
            })
            ->editColumn('periode', function (BudgetDto $budgetDto) {
                return $budgetDto->periode;
            })
            ->editColumn('total', function (BudgetDto $budgetDto) {
                return Helper::formatRupiah($budgetDto->total);
            })
            ->editColumn('action', function (BudgetDto $budgetDto) {
                return '<button type="button" data-budget="' . $budgetDto->id . '" class="btn btn-sm btn-primary select-budget">select</button>';
            })
            ->rawColumns(['action'])
            ->make();
    }
}
