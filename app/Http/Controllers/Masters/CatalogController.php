<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Http\Requests\Masters\CatalogStoreRequest;
use App\Models\Masters\Catalog;
use App\Services\Masters\CatalogService;
use Illuminate\Http\Request;
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

    public function datatable(Request $request)
    {
        return DataTables::of($this->service->all($request->get('search')))
            ->editColumn('unit_model', function ($catalog) {
                return $catalog->_source->unit_model;
            })
            ->editColumn('unit_type', function ($catalog) {
                return $catalog->_source->unit_type;
            })
            ->editColumn('seri', function ($catalog) {
                return $catalog->_source->seri;
            })
            ->editColumn('unit_class', function ($catalog) {
                return $catalog->_source->unit_class;
            })
            ->editColumn('brand', function ($catalog) {
                return $catalog->_source->brand;
            })
            ->editColumn('spesification', function ($catalog) {
                return $catalog->_source->spesification;
            })
            ->editColumn('action', function ($catalog) {
                return view('masters.catalog.action', compact('catalog'))->render();
            })
            ->rawColumns(['action'])
            ->make();
    }

    public function store(CatalogStoreRequest $request)
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
