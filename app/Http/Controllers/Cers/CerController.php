<?php

namespace App\Http\Controllers\Cers;

use App\DataTransferObjects\API\HRIS\EmployeeData;
use App\DataTransferObjects\Cers\CerData;
use App\Enums\Asset\Status;
use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Cers\CerRequest;
use App\Models\Assets\Asset;
use App\Models\Cers\Cer;
use App\Services\API\TXIS\BudgetService;
use App\Services\Assets\AssetService;
use App\Services\Cers\CerService;
use Yajra\DataTables\Facades\DataTables;

class CerController extends Controller
{
    public function __construct(
        private CerService $service,
        private BudgetService $budgetService,
        private AssetService $assetService,
    ) {
    }

    public function index()
    {
        return view('cers.cer.index');
    }

    public function datatable()
    {
        return DataTables::of($this->service->all())
            ->editColumn('type_budget', function (Cer $cer) {
                return $cer->type_budget?->badge();
            })
            ->editColumn('budget_ref', function (Cer $cer) {
                return $cer->budget_ref ?? '-';
            })
            ->editColumn('peruntukan', function (Cer $cer) {
                return $cer->peruntukan?->badge();
            })
            ->editColumn('tgl_kebutuhan', function (Cer $cer) {
                return $cer->tgl_kebutuhan;
            })
            ->editColumn('sumber_pendanaan', function (Cer $cer) {
                return $cer->sumber_pendanaan?->badge();
            })
            ->editColumn('status', function (Cer $cer) {
                return $cer->status?->badge();
            })
            ->editColumn('action', function (Cer $cer) {
                return view('cers.cer.action', compact('cer'))->render();
            })
            ->rawColumns(['action', 'type_budget', 'peruntukan', 'sumber_pendanaan', 'status',])
            ->make();
    }

    public function datatableAssetIdle()
    {
        return DataTables::of($this->assetService->getByStatus(Status::IDLE))
            ->editColumn('kode', function (Asset $asset) {
                return $asset->kode;
            })
            ->editColumn('description', function (Asset $asset) {
                return $asset->unit?->spesification;
            })
            ->editColumn('model', function (Asset $asset) {
                return $asset->unit?->model;
            })
            ->editColumn('est_umur', function (Asset $asset) {
                return $asset->depreciation?->umur_asset;
            })
            ->editColumn('unit_price', function (Asset $asset) {
                return Helper::formatRupiah($asset->leasing?->harga_beli);
            })
            ->editColumn('action', function (Asset $asset) {
                return '<button type="button" data-asset="' . $asset->getKey() . '" class="btn btn-sm btn-primary select-asset">select</button>';
            })
            ->rawColumns(['action'])
            ->make();
    }

    public function create()
    {
        return view('cers.cer.create', [
            'employee' => EmployeeData::from($this->service->getEmployee())
        ]);
    }

    public function store(CerRequest $request)
    {
        try {
            $data = CerData::from($request->all());
            $this->service->updateOrCreate($data);
            return response()->json([
                'message' => 'Berhasil disimpan'
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function edit(Cer $cer)
    {
        try {
            $cer->loadMissing(['items', 'workflows']);
            $data = CerData::from($cer);
            return view('cers.cer.edit', [
                'cer' => $data,
                'employee' => $data->employee,
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function destroy(Cer $cer)
    {
        try {
            $this->service->delete($cer);
            return response()->json([
                'message' => 'Berhasil dihapus'
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
