<?php

namespace App\Http\Controllers\Cers;

use App\DataTransferObjects\API\HRIS\EmployeeData;
use App\DataTransferObjects\Cers\CerData;
use App\DataTransferObjects\Masters\UomData;
use App\Enums\Asset\Status;
use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Cers\CerRequest;
use App\Models\Assets\Asset;
use App\Models\Cers\Cer;
use App\Models\Project;
use App\Services\API\TXIS\BudgetService;
use App\Services\Assets\AssetService;
use App\Services\Cers\CerService;
use App\Services\Masters\UomService;
use Illuminate\Http\Request;
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

    public function datatable(Request $request)
    {
        return DataTables::of($this->service->all($request->get('search')))
            ->editColumn('no_cer', function ($cer) {
                return $cer->no_cer;
            })
            ->editColumn('type_budget', function ($cer) {
                return $cer->type_budget?->badge();
            })
            ->editColumn('budget_ref', function ($cer) {
                return $cer->budget_ref ?? '-';
            })
            ->editColumn('peruntukan', function ($cer) {
                return $cer->peruntukan?->badge();
            })
            ->editColumn('tgl_kebutuhan', function ($cer) {
                return $cer->tgl_kebutuhan;
            })
            ->editColumn('sumber_pendanaan', function ($cer) {
                return $cer->sumber_pendanaan?->badge();
            })
            ->editColumn('status', function ($cer) {
                return $cer->status?->badge();
            })
            ->editColumn('action', function ($cer) {
                return view('cers.cer.action', compact('cer'))->render();
            })
            ->rawColumns(['action', 'type_budget', 'peruntukan', 'sumber_pendanaan', 'status',])
            ->make();
    }

    public function datatableAssetIdle()
    {
        return DataTables::of($this->assetService->allNotElastic())
            ->editColumn('kode', function (Asset $asset) {
                return $asset->kode;
            })
            ->editColumn('description', function (Asset $asset) {
                return $asset->assetUnit?->spesification;
            })
            ->editColumn('model', function (Asset $asset) {
                return $asset->assetUnit?->unit?->model;
            })
            ->editColumn('uom', function (Asset $asset) {
                return '<span data-id="' . $asset->uom_id . '">' . $asset->uom?->name . '</span>';
            })
            ->editColumn('est_umur', function (Asset $asset) {
                return $asset->lifetime?->masa_pakai;
            })
            ->editColumn('unit_price', function (Asset $asset) {
                return Helper::formatRupiah($asset->leasing?->harga_beli);
            })
            ->editColumn('action', function (Asset $asset) {
                return '<button type="button" data-asset="' . $asset->getKey() . '" class="btn btn-sm btn-primary select-asset">select</button>';
            })
            ->rawColumns(['action', 'uom'])
            ->make();
    }

    public function show(Cer $cer)
    {
        $cer->load(['items.uom', 'workflows' => function ($query) {
            $query->orderBy('sequence', 'ASC');
        }]);
        $data = CerData::from($cer);
        return view('cers.cer.show', [
            'cer' => $data,
            'employee' => $data->employee,
        ]);
    }

    public function create()
    {
        return view('cers.cer.create', [
            'employee' => EmployeeData::from($this->service->getEmployee()),
            'uoms' => UomData::collection(UomService::dataForSelect()),
        ]);
    }

    public function store(CerRequest $request)
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

    public function storeDraft(CerRequest $request)
    {
        try {
            $this->service->updateOrCreate($request, true);
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
            $cer->loadMissing(['items.uom', 'workflows']);
            $data = CerData::from($cer);
            return view('cers.cer.edit', [
                'cer' => $data,
                'employee' => $data->employee,
                'uoms' => UomData::collection(UomService::dataForSelect()),
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
