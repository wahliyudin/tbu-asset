<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Http\Requests\Masters\UomStoreRequest;
use App\Models\Masters\Uom;
use App\Services\Masters\UomService;

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
        return datatables()->of($this->service->all())
            ->editColumn('action', function ($uom) {
                return view('masters.uom.action', compact('uom'))->render();
            })
            ->rawColumns(['action'])
            ->make();
    }

    public function store(UomStoreRequest $request)
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
            $uom = $this->service->getDataForEdit($id);
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
