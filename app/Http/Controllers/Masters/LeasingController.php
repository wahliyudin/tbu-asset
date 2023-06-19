<?php

namespace App\Http\Controllers\Masters;

use App\DataTransferObjects\Masters\LeasingDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Masters\LeasingRequest;
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
        return view('master.leasing.index');
    }

    public function datatable()
    {
        return DataTables::of($this->service->all())
            ->editColumn('action', function (Leasing $leasing) {
                return view('master.leasing.action', compact('leasing'))->render();
            })
            ->rawColumns(['action'])
            ->make();
    }

    public function store(LeasingRequest $request)
    {
        try {
            $this->service->updateOrCreate(LeasingDto::fromRequest($request));
            return response()->json([
                'message' => 'Berhasil disimpan'
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function edit(Leasing $leasing)
    {
        try {
            return response()->json($leasing);
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
