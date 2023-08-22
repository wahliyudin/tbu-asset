<?php

namespace App\Http\Controllers\Masters;

use App\DataTransferObjects\Masters\DealerData;
use App\Http\Controllers\Controller;
use App\Http\Requests\Masters\DealerStoreRequest;
use App\Models\Masters\Dealer;
use App\Services\Masters\DealerService;
use Yajra\DataTables\Facades\DataTables;

class DealerController extends Controller
{
    public function __construct(
        private DealerService $service
    ) {
    }

    public function index()
    {
        return view('masters.dealer.index');
    }

    public function datatable()
    {
        return DataTables::of($this->service->all())
            ->editColumn('action', function (Dealer $dealer) {
                return view('masters.dealer.action', compact('dealer'))->render();
            })
            ->rawColumns(['action'])
            ->make();
    }

    public function store(DealerStoreRequest $request)
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

    public function edit(Dealer $dealer)
    {
        try {
            return response()->json($dealer);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function destroy(Dealer $dealer)
    {
        try {
            $this->service->delete($dealer);
            return response()->json([
                'message' => 'Berhasil dihapus'
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
