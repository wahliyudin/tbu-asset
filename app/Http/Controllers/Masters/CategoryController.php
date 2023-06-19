<?php

namespace App\Http\Controllers\Masters;

use App\DataTransferObjects\Masters\CategoryDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Masters\CategoryRequest;
use App\Models\Masters\Category;
use App\Services\Masters\CategoryService;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{
    public function __construct(
        private CategoryService $service
    ) {
    }

    public function index()
    {
        return view('master.category.index');
    }

    public function datatable()
    {
        return DataTables::of($this->service->all())
            ->editColumn('action', function (Category $category) {
                return view('master.category.action', compact('category'))->render();
            })
            ->rawColumns(['action'])
            ->make();
    }

    public function store(CategoryRequest $request)
    {
        try {
            $this->service->updateOrCreate(CategoryDto::fromRequest($request));
            return response()->json([
                'message' => 'Berhasil disimpan'
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function edit(Category $category)
    {
        try {
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
