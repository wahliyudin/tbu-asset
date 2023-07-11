<?php

namespace App\Http\Controllers\ThirdParty\TXIS;

use App\DataTransferObjects\API\TXIS\BudgetData;
use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Services\API\TXIS\BudgetService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class BudgetController extends Controller
{
    public function __construct(
        protected BudgetService $budgetService
    ) {
    }

    public function datatable(Request $request)
    {
        $budgets = $this->budgetService->all($request->deptcode);
        return DataTables::of(BudgetData::collection(isset($budgets['data']) ? $budgets['data'] : [])->toCollection())
            ->editColumn('kode', function (BudgetData $budgetData) {
                return $budgetData->kode;
            })
            ->editColumn('periode', function (BudgetData $budgetData) {
                return $budgetData->periode;
            })
            ->editColumn('total', function (BudgetData $budgetData) {
                return Helper::formatRupiah($budgetData->total);
            })
            ->editColumn('action', function (BudgetData $budgetData) {
                return '<button type="button" data-budget="' . $budgetData->id . '" class="btn btn-sm btn-primary select-budget">select</button>';
            })
            ->rawColumns(['action'])
            ->make();
    }
}
