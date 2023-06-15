<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{
    public function index()
    {
        return view('master.category.index');
    }

    public function datatable()
    {
        $data = Category::query()->get();
        return DataTables::of($data)
            ->editColumn('action', function (Category $category) {
                return view('master.category.action', compact('category'))->render();
            })
            ->rawColumns(['action'])
            ->make();
    }

    public function store(Request $request)
    {
        try {
            Category::query()->updateOrCreate([
                'id' => $request->key
            ], [
                'name' => $request->name,
            ]);
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
            $category->delete();
            return response()->json([
                'message' => 'Berhasil dihapus'
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}