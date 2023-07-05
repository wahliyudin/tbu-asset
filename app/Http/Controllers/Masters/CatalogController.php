<?php

namespace App\Http\Controllers\Masters;

use App\DataTransferObjects\Masters\CatalogData;
use App\Http\Controllers\Controller;
use App\Models\Masters\Catalog;
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
        return view('masters.catalog.index');
    }

    public function datatable()
    {
        return DataTables::of($this->service->all())
            ->editColumn('action', function (Catalog $catalog) {
                return view('masters.catalog.action', compact('catalog'))->render();
            })
            ->rawColumns(['action'])
            ->make();
    }

    public function store(CatalogData $data)
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