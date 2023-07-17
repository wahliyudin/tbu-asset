<?php

namespace App\Http\Controllers\Masters;

use App\DataTransferObjects\Masters\ClusterData;
use App\Facades\Elasticsearch;
use App\Http\Controllers\Controller;
use App\Models\Masters\Cluster;
use App\Services\Masters\CategoryService;
use App\Services\Masters\ClusterService;
use Illuminate\Http\Request;
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

    public function datatable(Request $request)
    {
        return DataTables::of($this->service->all($request->get('search')))
            ->editColumn('category', function ($cluster) {
                return $cluster->_source->category?->name;
            })
            ->editColumn('name', function ($cluster) {
                return $cluster->_source->name;
            })
            ->editColumn('action', function ($cluster) {
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

    public function edit($id)
    {
        try {
            return response()->json($this->service->getDataForEdit($id));
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
