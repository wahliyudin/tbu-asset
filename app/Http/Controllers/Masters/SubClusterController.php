<?php

namespace App\Http\Controllers\Masters;

use App\DataTransferObjects\Masters\SubClusterData;
use App\Http\Controllers\Controller;
use App\Models\Masters\SubCluster;
use App\Services\Masters\ClusterService;
use App\Services\Masters\SubClusterService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SubClusterController extends Controller
{
    public function __construct(
        private SubClusterService $service,
        private ClusterService $clusterService,
    ) {
    }

    public function index()
    {
        $clusters = $this->clusterService->all();
        return view('masters.sub-cluster.index', [
            'clusters' => $clusters
        ]);
    }

    public function datatable(Request $request)
    {
        return DataTables::of($this->service->all($request->get('search')))
            ->editColumn('cluster', function ($subCluster) {
                return $subCluster->_source->cluster?->name;
            })
            ->editColumn('name', function ($subCluster) {
                return $subCluster->_source->name;
            })
            ->editColumn('action', function ($subCluster) {
                return view('masters.sub-cluster.action', compact('subCluster'))->render();
            })
            ->rawColumns(['action'])
            ->make();
    }

    public function store(SubClusterData $data)
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
