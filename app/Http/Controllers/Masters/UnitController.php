<?php

namespace App\Http\Controllers\Masters;

use App\DataTransferObjects\Masters\UnitDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Masters\UnitRequest;
use App\Masters\Models\Unit;
use App\Services\Masters\UnitService;
use Yajra\DataTables\Facades\DataTables;

class UnitController extends Controller
{
    public function __construct(
        private UnitService $service
    ) {
    }

    public function index()
    {
        return view('master.unit.index');
    }

    public function datatable()
    {
        return DataTables::of($this->service->all())
            ->editColumn('action', function (Unit $unit) {
                return view('master.unit.action', compact('unit'))->render();
            })
            ->rawColumns(['action'])
            ->make();
    }

    public function store(UnitRequest $request)
    {
        try {
            $this->service->updateOrCreate(UnitDto::fromRequest($request));
            return response()->json([
                'message' => 'Berhasil disimpan'
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function edit(Unit $unit)
    {
        try {
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
}
