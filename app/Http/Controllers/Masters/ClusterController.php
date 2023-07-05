<?php

namespace App\Http\Controllers\Masters;

use App\DataTransferObjects\Masters\ClusterData;
use App\Http\Controllers\Controller;
use App\Models\Masters\Cluster;
use App\Services\Masters\CategoryService;
use App\Services\Masters\ClusterService;
use Yajra\DataTables\Facades\DataTables;

class ClusterController extends Controller
{
    public function __construct(
        private ClusterService $service,
        private CategoryService $categoryService,
    ) {
    }

    public function index()
    {
        $categories = $this->categoryService->all();
        return view('masters.cluster.index', [
            'categories' => $categories
        ]);
    }

    public function datatable()
    {
        return DataTables::of($this->service->all())
            ->editColumn('category', function (Cluster $cluster) {
                return $cluster->category?->name;
            })
            ->editColumn('action', function (Cluster $cluster) {
                return view('masters.cluster.action', compact('cluster'))->render();
            })
            ->rawColumns(['action'])
            ->make();
    }

    public function store(ClusterData $data)
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

    public function edit(Cluster $cluster)
    {
        try {
            return response()->json($cluster);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function destroy(Cluster $cluster)
    {
        try {
            $this->service->delete($cluster);
            return response()->json([
                'message' => 'Berhasil dihapus'
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}