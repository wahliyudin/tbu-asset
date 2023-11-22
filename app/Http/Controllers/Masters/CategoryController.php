<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Http\Requests\Masters\CategoryStoreRequest;
use App\Models\Masters\Category;
use App\Services\Masters\CategoryService;

class CategoryController extends Controller
{
    public function __construct(
        private CategoryService $service,
    ) {
    }

    public function index()
    {
        return view('masters.category.index');
    }

    public function datatable()
    {
        return datatables()->of($this->service->all())
            ->editColumn('name', function ($category) {
                return $category->name;
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
            $category = $this->service->getDataForEdit($id);
            return response()->json($category);
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
