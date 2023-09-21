<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Http\Requests\Masters\ConditionRequest;
use App\Models\Masters\Condition;
use App\Services\Masters\ConditionService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ConditionController extends Controller
{
    public function __construct(
        private ConditionService $service
    ) {
    }

    public function index()
    {
        return view('masters.condition.index');
    }

    public function datatable()
    {
        return DataTables::of($this->service->all())
            ->editColumn('name', function ($condition) {
                return $condition->name;
            })
            ->editColumn('action', function ($condition) {
                return view('masters.condition.action', compact('condition'))->render();
            })
            ->rawColumns(['action'])
            ->make();
    }

    public function store(ConditionRequest $request)
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

    public function edit(Condition $condition)
    {
        try {
            return response()->json($condition);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function destroy(Condition $condition)
    {
        try {
            $this->service->delete($condition);
            return response()->json([
                'message' => 'Berhasil dihapus'
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
