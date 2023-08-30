<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Http\Requests\Masters\SubClusterStoreRequest;
use App\Models\Masters\SubCluster;
use App\Services\Masters\ClusterService;
use App\Services\Masters\SubClusterService;
use Illuminate\Http\Request;
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

    public function datatable(Request $request)
    {
        return DataTables::of($this->service->all($request->get('search'), $request->get('length')))
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
