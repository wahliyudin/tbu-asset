<?php

namespace App\Http\Controllers\Masters;

use App\DataTransferObjects\Masters\CatalogDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Masters\CatalogRequest;
use App\Models\Catalog;
use App\Services\Masters\CatalogService;
use Yajra\DataTables\Facades\DataTables;

class CatalogController extends Controller
{
    public function __construct(
        private CatalogService $service,
    ) {
    }

    public function index()
    {
        return view('master.catalog.index');
    }

    public function datatable()
    {
        return DataTables::of($this->service->all())
            ->editColumn('action', function (Catalog $catalog) {
                return view('master.catalog.action', compact('catalog'))->render();
            })
            ->rawColumns(['action'])
            ->make();
    }

    public function store(CatalogRequest $request)
    {
        try {
            $this->service->updateOrCreate(CatalogDto::fromRequest($request));
            return response()->json([
                'message' => 'Berhasil disimpan'
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function edit(Catalog $catalog)
    {
        try {
            return response()->json($catalog);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function destroy(Catalog $catalog)
    {
        try {
            $this->service->delete($catalog);
            return response()->json([
                'message' => 'Berhasil dihapus'
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}