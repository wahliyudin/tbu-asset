<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Http\Requests\Masters\ClusterStoreRequest;
use App\Models\Masters\Cluster;
use App\Services\Masters\CategoryService;
use App\Services\Masters\ClusterService;
use Yajra\DataTables\Facades\DataTables;

class ClusterController extends Controller
{
    public function __construct(
        private ClusterService $service,
    ) {
    }

    public function index()
    {
        return view('masters.cluster.index', [
            'categories' => CategoryService::dataForSelect()
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

    public function store(ClusterStoreRequest $request)
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
