<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Http\Requests\Masters\CategoryStoreRequest;
use App\Models\Masters\Category;
use App\Services\Masters\CategoryService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{
    public function __construct(
        private CategoryService $service
    ) {
    }

    public function index()
    {
        return view('masters.category.index');
    }

    public function datatable(Request $request)
    {
        return DataTables::of($this->service->all($request->get('search')))
            ->editColumn('name', function ($category) {
                return $category->_source->name;
            })
            ->editColumn('action', function ($category) {
                return view('masters.category.action', compact('category'))->render();
            })
            ->rawColumns(['action'])
            ->make();
    }

    public function store(CategoryStoreRequest $request)
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

    public function destroy(Category $category)
    {
        try {
            $this->service->delete($category);
            return response()->json([
                'message' => 'Berhasil dihapus'
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
