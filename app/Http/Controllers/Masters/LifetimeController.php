<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Http\Requests\Masters\LifetimeRequest;
use App\Models\Masters\Lifetime;
use App\Services\Masters\LifetimeService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class LifetimeController extends Controller
{
    public function __construct(
        private LifetimeService $service
    ) {
    }

    public function index()
    {
        return view('masters.lifetime.index');
    }

    public function datatable()
    {
        return DataTables::of($this->service->all())
            ->editColumn('masa_pakai', function ($lifetime) {
                return $lifetime->masa_pakai;
            })
            ->editColumn('action', function ($lifetime) {
                return view('masters.lifetime.action', compact('lifetime'))->render();
            })
            ->rawColumns(['action'])
            ->make();
    }

    public function store(LifetimeRequest $request)
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

    public function edit(Lifetime $lifetime)
    {
        try {
            return response()->json($lifetime);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function destroy(Lifetime $lifetime)
    {
        try {
            $this->service->delete($lifetime);
            return response()->json([
                'message' => 'Berhasil dihapus'
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
