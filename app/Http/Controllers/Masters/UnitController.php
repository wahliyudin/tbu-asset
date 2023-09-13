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
            ->editColumn('model', function ($unit) {
                return $unit->_source->model;
            })
            ->editColumn('type', function ($unit) {
                return $unit->_source->type;
            })
            ->editColumn('seri', function ($unit) {
                return $unit->_source->seri;
            })
            ->editColumn('class', function ($unit) {
                return $unit->_source->class;
            })
            ->editColumn('brand', function ($unit) {
                return $unit->_source->brand;
            })
            ->editColumn('serial_number', function ($unit) {
                return $unit->_source->serial_number;
            })
            ->editColumn('spesification', function ($unit) {
                return $unit->_source->spesification;
            })
            ->editColumn('tahun_pembuatan', function ($unit) {
                return $unit->_source->tahun_pembuatan;
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
