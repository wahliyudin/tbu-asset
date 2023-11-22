<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Http\Requests\Masters\ClusterStoreRequest;
use App\Models\Masters\Cluster;
use App\Services\Masters\CategoryService;
use App\Services\Masters\ClusterService;

class ClusterController extends Controller
{
    public function __construct(
        private ClusterService $clusterService,
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
        return datatables()->of($this->clusterService->all())
            ->editColumn('name', function ($cluster) {
                return $cluster->name;
            })
            ->editColumn('action', function ($cluster) {
                return view('masters.cluster.action', compact('cluster'))->render();
            })
            ->rawColumns(['action'])
            ->make();
    }

    public function store(ClusterStoreRequest $request)
    {
        try {
            $this->clusterService->updateOrCreate($request);
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
            $cluster = $this->clusterService->getDataForEdit($id);
            return response()->json($cluster);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function destroy(Cluster $cluster)
    {
        try {
            $this->clusterService->delete($cluster);
            return response()->json([
                'message' => 'Berhasil dihapus'
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
