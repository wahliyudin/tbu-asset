<?php

namespace App\Http\Controllers\Masters;

use App\DataTransferObjects\Masters\UomDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Masters\UomRequest;
use App\Models\Masters\Uom;
use App\Services\Masters\UomService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class UomController extends Controller
{
    public function __construct(
        private UomService $service,
    ) {
    }

    public function index()
    {
        return view('masters.uom.index');
    }

    public function datatable()
    {
        return DataTables::of($this->service->all())
            ->editColumn('action', function (Uom $uom) {
                return view('masters.uom.action', compact('uom'))->render();
            })
            ->rawColumns(['action'])
            ->make();
    }

    public function store(UomRequest $request)
    {
        try {
            $this->service->updateOrCreate(UomDto::fromRequest($request));
            return response()->json([
                'message' => 'Berhasil disimpan'
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function edit(Uom $uom)
    {
        try {
            return response()->json($uom);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function destroy(Uom $uom)
    {
        try {
            $this->service->delete($uom);
            return response()->json([
                'message' => 'Berhasil dihapus'
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
