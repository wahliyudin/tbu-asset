<?php

namespace App\Http\Controllers\Masters;

use App\DataTransferObjects\Masters\LeasingData;
use App\Http\Controllers\Controller;
use App\Models\Masters\Leasing;
use App\Services\Masters\LeasingService;
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

    public function datatable()
    {
        return DataTables::of($this->service->all())
            ->editColumn('action', function (Leasing $leasing) {
                return view('masters.leasing.action', compact('leasing'))->render();
            })
            ->rawColumns(['action'])
            ->make();
    }

    public function store(LeasingData $data)
    {
        try {
            $this->service->updateOrCreate($data);
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