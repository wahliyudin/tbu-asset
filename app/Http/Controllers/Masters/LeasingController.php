<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Http\Requests\Masters\LeasingStoreRequest;
use App\Models\Masters\Leasing;
use App\Services\Masters\LeasingService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class LeasingController extends Controller
{
    public function __construct(
        private LeasingService $service
    ) {
    }

    public function index()
    {
        return view('masters.leasing.index');
    }

    public function datatable(Request $request)
    {
        return DataTables::of($this->service->all($request->get('search')))
            ->editColumn('name', function ($leasing) {
                return $leasing->_source->name;
            })
            ->editColumn('action', function ($leasing) {
                return view('masters.leasing.action', compact('leasing'))->render();
            })
            ->rawColumns(['action'])
            ->make();
    }

    public function store(LeasingStoreRequest $request)
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

    public function destroy(Leasing $leasing)
    {
        try {
            $this->service->delete($leasing);
            return response()->json([
                'message' => 'Berhasil dihapus'
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
