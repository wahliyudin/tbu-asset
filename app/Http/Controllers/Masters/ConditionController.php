<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Http\Requests\Masters\ConditionRequest;
use App\Models\Masters\Condition;
use App\Services\Masters\ConditionService;

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
        return datatables()->of($this->service->all())
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

    public function dataForSelect()
    {
        try {
            $data = $this->service->dataForSelect();
            return response()->json($data);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
