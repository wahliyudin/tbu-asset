<?php

namespace App\Http\Controllers\Cers;

use App\DataTransferObjects\Cers\CerItemData;
use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Assets\AssetRequest;
use App\Models\Cers\CerItem;
use App\Services\Assets\AssetService;
use App\Services\Cers\CerItemService;
use App\Services\GlobalService;
use App\Services\Masters\DealerService;
use App\Services\Masters\LeasingService;
use App\Services\Masters\SubClusterService;
use App\Services\Masters\UnitService;
use App\Services\Masters\UomService;
use Yajra\DataTables\Facades\DataTables;

class RegisterController extends Controller
{
    public function __construct(
        protected CerItemService $cerItemService,
        protected AssetService $assetService,
    ) {
    }

    public function index()
    {
        return view('cers.register.index');
    }

    public function datatable()
    {
        return DataTables::of($this->cerItemService->getAllByReadyToRegister())
            ->editColumn('no_cer', function (CerItem $cerItem) {
                return $cerItem->cer?->no_cer ?? '-';
            })
            ->editColumn('description', function (CerItem $cerItem) {
                return $cerItem->description ?? '-';
            })
            ->editColumn('model', function (CerItem $cerItem) {
                return $cerItem->model ?? '-';
            })
            ->editColumn('est_umur', function (CerItem $cerItem) {
                return ($cerItem->est_umur ?? '-') . ' Bulan';
            })
            ->editColumn('qty', function (CerItem $cerItem) {
                return $cerItem->qty ?? '-';
            })
            ->editColumn('price', function (CerItem $cerItem) {
                return Helper::formatRupiah($cerItem->price);
            })
            ->editColumn('action', function (CerItem $cerItem) {
                return view('cers.register.action', compact('cerItem'))->render();
            })
            ->rawColumns(['action'])
            ->make();
    }

    public function create(CerItem $cerItem)
    {
        $cerItem->loadMissing(['cer']);
        // dd($cerItem->toArray());
        $data = CerItemData::from($cerItem);
        $cerItemDetail = $this->cerItemService->getByCerItemId($cerItem->id);
        return view('cers.register.register', [
            'cerItem' => $data,
            'cerItemDetail' => $cerItemDetail,
            'units' => UnitService::dataForSelect(),
            'uoms' => UomService::dataForSelect(),
            'subClusters' => SubClusterService::dataForSelect(),
            'dealers' => DealerService::dataForSelect(),
            'leasings' => LeasingService::dataForSelect(),
            'employees' => GlobalService::getEmployees(['nik', 'nama_karyawan'])->toCollection(),
            'projects' => GlobalService::getProjects(),
        ]);
    }

    public function store(CerItem $cerItem, AssetRequest $request)
    {
        try {
            $this->assetService->updateOrCreate($request);
            return response()->json([
                'message' => "Berhasil diregister"
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
