<?php

namespace App\Http\Controllers\Cers;

use App\DataTransferObjects\Cers\CerItemData;
use App\Enums\Cers\StatusTXIS;
use App\Facades\Assets\AssetService;
use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Assets\AssetRequest;
use App\Models\Cers\CerItem;
use App\Services\Cers\CerItemService;
use App\Services\GlobalService;
use App\Services\Masters\ActivityService;
use App\Services\Masters\ConditionService;
use App\Services\Masters\LeasingService;
use App\Services\Masters\LifetimeService;
use App\Services\Masters\SubClusterService;
use App\Services\Masters\UnitService;
use App\Services\Masters\UomService;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;

class RegisterController extends Controller
{
    public function __construct(
        protected CerItemService $cerItemService,

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
        $cerItem->loadMissing([
            'cer.employee.position.divisi',
            'cer.employee.position.department',
            'cer.employee.position.project',
            'unit',
        ]);
        $data = CerItemData::from($cerItem);
        $cerItemDetail = $this->cerItemService->getByCerItemId($cerItem->id);
        return view('cers.register.register', [
            'cerItem' => $data,
            'kode' => AssetService::nextKode($cerItemDetail['asset_number']),
            'cerItemDetail' => $cerItemDetail,
            'units' => UnitService::dataForSelect(),
            'lifetimes' => LifetimeService::dataForSelect(),
            'activities' => ActivityService::dataForSelect(),
            'conditions' => ConditionService::dataForSelect(),
            'uoms' => UomService::dataForSelect(),
            'subClusters' => SubClusterService::dataForSelect(),
            'dealers' => GlobalService::vendorForSelect(),
            'leasings' => LeasingService::dataForSelect(),
            'employees' => GlobalService::getEmployees(['nik', 'nama_karyawan'])->toCollection(),
            'projects' => GlobalService::getProjects(),
        ]);
    }

    public function store(CerItem $cerItem, AssetRequest $request)
    {
        try {
            $this->cerItemService->register($cerItem, $request);
            return response()->json([
                'message' => "Berhasil diregister"
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function history($id)
    {
        try {
            $response = $this->cerItemService->getByCerItemId($id);
            // dd($response);
            return response()->json([
                'is_register' => isset($response['gr']['status_gr']) ? $response['gr']['status_gr'] : false,
                [
                    'no' => isset($response['pr']['pr']) ? $response['pr']['pr'] : '-',
                    'badge' => StatusTXIS::byValue(isset($response['pr']['status']) ? $response['pr']['status'] : null)?->badge() ?? '-',
                    'date' => isset($response['pr']['prdate']) ? Carbon::parse($response['pr']['prdate'])->translatedFormat('d F Y') : '-',
                ],
                [
                    'no' => isset($response['po']['po']) ? $response['po']['po'] : '-',
                    'badge' => StatusTXIS::byValue(isset($response['po']['status']) ? $response['po']['status'] : null)?->badge() ?? '-',
                    'date' => isset($response['po']['podate']) ? Carbon::parse($response['po']['podate'])->translatedFormat('d F Y') : '-',
                ],
                [
                    'no' => isset($response['gr']['gr']) ? $response['gr']['gr'] : '-',
                    'badge' => StatusTXIS::byValue(isset($response['gr']['status']) ? $response['gr']['status'] : null)?->badge() ?? '-',
                    'date' => isset($response['gr']['tgl_gr']) ? Carbon::parse($response['gr']['tgl_gr'])->translatedFormat('d F Y') : '-',
                    'doc_bast' => isset($response['gr']['doc_bast']) ? $response['gr']['doc_bast'] : '#',
                ],
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
