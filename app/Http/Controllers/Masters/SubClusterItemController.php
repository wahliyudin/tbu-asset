<?php

namespace App\Http\Controllers\Masters;

use App\DataTransferObjects\Masters\SubClusterItemData;
use App\Http\Controllers\Controller;
use App\Models\Masters\SubClusterItem;
use App\Services\Masters\SubClusterItemService;
use App\Services\Masters\SubClusterService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SubClusterItemController extends Controller
{
    public function __construct(
        private SubClusterItemService $service,
        private SubClusterService $subClusterService,
    ) {
    }

    public function index()
    {
        $subClusters = $this->subClusterService->all();
        return view('masters.sub-cluster-item.index', [
            'subClusters' => $subClusters
        ]);
    }

    public function datatable(Request $request)
    {
        return DataTables::of($this->service->all($request->get('search')))
            ->editColumn('sub_cluster', function ($subClusterItem) {
                return $subClusterItem->_source->sub_cluster?->name;
            })
            ->editColumn('name', function ($subClusterItem) {
                return $subClusterItem->_source->name;
            })
            ->editColumn('action', function ($subClusterItem) {
                return view('masters.sub-cluster-item.action', compact('subClusterItem'))->render();
            })
            ->rawColumns(['action'])
            ->make();
    }

    public function store(SubClusterItemData $data)
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

    public function destroy(SubClusterItem $subClusterItem)
    {
        try {
            $this->service->delete($subClusterItem);
            return response()->json([
                'message' => 'Berhasil dihapus'
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
