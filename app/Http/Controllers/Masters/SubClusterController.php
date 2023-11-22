<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Http\Requests\Masters\SubClusterStoreRequest;
use App\Models\Masters\SubCluster;
use App\Services\Masters\ClusterService;
use App\Services\Masters\SubClusterService;

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
        return datatables()->of($this->service->all())
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
            $subCluster = $this->service->getDataForEdit($id);
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

    public function dataForSelect()
    {
        try {
            $data = $this->service->dataForSelect();
            return response()->json($data);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
