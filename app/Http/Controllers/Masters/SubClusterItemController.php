<?php

namespace App\Http\Controllers\Masters;

use App\DataTransferObjects\Masters\SubClusterItemDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Masters\SubClusterItemRequest;
use App\Models\SubClusterItem;
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
        return view('master.sub-cluster-item.index', [
            'subClusters' => $subClusters
        ]);
    }

    public function datatable()
    {
        return DataTables::of($this->service->all())
            ->editColumn('sub_cluster', function (SubClusterItem $subClusterItem) {
                return $subClusterItem->subCluster?->name;
            })
            ->editColumn('action', function (SubClusterItem $subClusterItem) {
                return view('master.sub-cluster-item.action', compact('subClusterItem'))->render();
            })
            ->rawColumns(['action'])
            ->make();
    }

    public function store(SubClusterItemRequest $request)
    {
        try {
            $this->service->updateOrCreate(SubClusterItemDto::fromRequest($request));
            return response()->json([
                'message' => 'Berhasil disimpan'
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function edit(SubClusterItem $subClusterItem)
    {
        try {
            return response()->json($subClusterItem);
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