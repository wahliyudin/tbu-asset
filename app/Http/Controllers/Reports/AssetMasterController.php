<?php

namespace App\Http\Controllers\Reports;

use App\Enums\Asset\Status;
use App\Exports\Reports\AssetMaster\AssetExport;
use App\Helpers\CarbonHelper;
use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Assets\Asset;
use App\Models\Project;
use App\Services\Assets\AssetService;
use App\Services\Masters\CategoryService;
use App\Services\Masters\ClusterService;
use App\Services\Masters\SubClusterService;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class AssetMasterController extends Controller
{
    public function __construct(
        protected AssetService $assetService
    ) {
    }

    public function index()
    {
        return view('reports.asset-master.index', [
            'projects' => Project::select(['project_id', 'project'])->get(),
            'categories' => CategoryService::dataForSelect(),
            'clusters' => ClusterService::dataForSelect(),
            'subClusters' => SubClusterService::dataForSelect(),
        ]);
    }

    public function datatable(Request $request)
    {
        $data = $this->assetService->dataForExport($request);
        return DataTables::of(collect($data)->pluck('_source'))
            ->editColumn('kode', function ($asset) {
                return $asset->kode;
            })
            ->editColumn('unit_kode', function ($asset) {
                return $asset->asset_unit?->kode;
            })
            ->editColumn('unit_type', function ($asset) {
                return $asset->asset_unit?->type;
            })
            ->editColumn('unit_seri', function ($asset) {
                return $asset->asset_unit?->seri;
            })
            ->editColumn('unit_class', function ($asset) {
                return $asset->asset_unit?->class;
            })
            ->editColumn('unit_brand', function ($asset) {
                return $asset->asset_unit?->brand;
            })
            ->editColumn('unit_serial_number', function ($asset) {
                return $asset->asset_unit?->serial_number;
            })
            ->editColumn('unit_spesification', function ($asset) {
                return $asset->asset_unit?->spesification;
            })
            ->editColumn('unit_tahun_pembuatan', function ($asset) {
                return $asset->asset_unit?->tahun_pembuatan;
            })
            ->editColumn('unit_kelengkapan_tambahan', function ($asset) {
                return $asset->asset_unit?->kelengkapan_tambahan;
            })
            ->editColumn('category', function ($asset) {
                return $asset->sub_cluster?->cluster?->category?->name;
            })
            ->editColumn('cluster', function ($asset) {
                return $asset->sub_cluster?->cluster?->name;
            })
            ->editColumn('sub_cluster', function ($asset) {
                return $asset->sub_cluster?->name;
            })
            ->editColumn('pic', function ($asset) {
                return $asset->employee?->nama_karyawan;
            })
            ->editColumn('activity', function ($asset) {
                return $asset->activity?->name;
            })
            ->editColumn('asset_location', function ($asset) {
                return $asset->project?->project;
            })
            ->editColumn('department', function ($asset) {
                return $asset->department?->department_name;
            })
            ->editColumn('condition', function ($asset) {
                return $asset->condition?->name;
            })
            ->editColumn('uom', function ($asset) {
                return $asset->uom?->name;
            })
            ->editColumn('quantity', function ($asset) {
                return $asset->quantity;
            })
            ->editColumn('masa_pakai', function ($asset) {
                return $asset->lifetime?->masa_pakai;
            })
            ->editColumn('nilai_sisa', function ($asset) {
                return Helper::formatRupiah($asset->nilai_sisa, true);
            })
            ->editColumn('tanggal_bast', function ($asset) {
                return CarbonHelper::dateFormatdFY($asset->tgl_bast);
            })
            ->editColumn('hm', function ($asset) {
                return $asset->hm;
            })
            ->editColumn('pr_number', function ($asset) {
                return $asset->pr_number;
            })
            ->editColumn('po_number', function ($asset) {
                return $asset->po_number;
            })
            ->editColumn('pr_number', function ($asset) {
                return $asset->pr_number;
            })
            ->editColumn('status_asset', function ($asset) {
                return $asset->status_asset;
            })
            ->editColumn('status', function ($asset) {
                return Status::match($asset->status)?->badge();
            })
            ->editColumn('remark', function ($asset) {
                return $asset->remark;
            })
            ->rawColumns(['status'])
            ->make();
    }

    public function export(Request $request)
    {
        $assets = $this->assetService->dataForExport($request);
        return Excel::download(new AssetExport(collect($assets)->pluck('_source')), 'assets.xlsx');
    }
}
