<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Http\Requests\Masters\UnitStoreRequest;
use App\Models\Masters\Unit;
use App\Services\Masters\UnitService;

class UnitController extends Controller
{
    public function __construct(
        private UnitService $service
    ) {
    }

    public function index()
    {
        return view('masters.unit.index');
    }

    public function datatable()
    {
        return datatables()->of($this->service->all())
            ->editColumn('action', function ($unit) {
                return view('masters.unit.action', compact('unit'))->render();
            })
            ->rawColumns(['action'])
            ->make();
    }

    public function store(UnitStoreRequest $request)
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

    public function edit($id)
    {
        try {
            $unit = $this->service->getDataForEdit($id);
            return response()->json($unit);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function destroy(Unit $unit)
    {
        try {
            $this->service->delete($unit);
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
