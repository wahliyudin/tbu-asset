<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Http\Requests\Masters\UnitStoreRequest;
use App\Models\Masters\Unit;
use App\Services\Masters\UnitService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

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

    public function datatable(Request $request)
    {
        return DataTables::of($this->service->all($request->get('search'), $request->get('length')))
            ->editColumn('prefix', function ($unit) {
                return $unit->_source->prefix;
            })
            ->editColumn('model', function ($unit) {
                return $unit->_source->model;
            })
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
            return response()->json($this->service->getDataForEdit($id));
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
}
