<?php

namespace App\Http\Controllers\Masters;

use App\DataTransferObjects\Masters\DealerDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Masters\DealerRequest;
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
        return view('master.dealer.index');
    }

    public function datatable()
    {
        return DataTables::of($this->service->all())
            ->editColumn('action', function (Dealer $dealer) {
                return view('master.dealer.action', compact('dealer'))->render();
            })
            ->rawColumns(['action'])
            ->make();
    }

    public function store(DealerRequest $request)
    {
        try {
            $this->service->updateOrCreate(DealerDto::fromRequest($request));
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
