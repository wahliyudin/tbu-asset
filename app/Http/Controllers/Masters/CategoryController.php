<?php

namespace App\Http\Controllers\Masters;

use App\DataTransferObjects\Masters\CategoryData;
use App\Http\Controllers\Controller;
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
        return view('masters.category.index');
    }

    public function datatable()
    {
        return DataTables::of($this->service->all())
            ->editColumn('name', function ($category) {
                return $category->_source->name;
            })
            ->editColumn('action', function ($category) {
                return view('masters.category.action', compact('category'))->render();
            })
            ->rawColumns(['action'])
            ->make();
    }

    public function store(CategoryData $data)
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
