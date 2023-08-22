<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Http\Requests\Masters\SubClusterStoreRequest;
use App\Models\Masters\SubCluster;
use App\Services\Masters\ClusterService;
use App\Services\Masters\SubClusterService;
use Yajra\DataTables\Facades\DataTables;

class SubClusterController extends Controller
{
    public function __construct(
        private SubClusterService $service,
    ) {
    }

    public function index()
    {
        return view('masters.sub-cluster.index', [
            'clusters' => ClusterService::dataForSelect()
        ]);
    }

    public function datatable()
    {
        return DataTables::of($this->service->all())
            ->editColumn('cluster', function (SubCluster $subCluster) {
                return $subCluster->cluster?->name;
            })
            ->editColumn('action', function (SubCluster $subCluster) {
                return view('masters.sub-cluster.action', compact('subCluster'))->render();
            })
            ->rawColumns(['action'])
            ->make();
    }

    public function store(SubClusterStoreRequest $request)
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

    public function edit(SubCluster $subCluster)
    {
        try {
            return response()->json($subCluster);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function destroy(SubCluster $subCluster)
    {
        try {
            $this->service->delete($subCluster);
            return response()->json([
                'message' => 'Berhasil dihapus'
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
