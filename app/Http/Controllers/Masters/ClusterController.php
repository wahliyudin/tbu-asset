<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Http\Requests\Masters\ClusterStoreRequest;
use App\Models\Masters\Cluster;
use App\Services\Masters\CategoryService;
use App\Services\Masters\ClusterService;
use Illuminate\Http\Request;
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
