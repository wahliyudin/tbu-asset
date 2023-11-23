<?php

namespace App\Http\Controllers\Transfers;

use App\DataTransferObjects\Assets\AssetData;
use App\DataTransferObjects\Transfers\AssetTransferData;
use App\Helpers\AuthHelper;
use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Transfers\AssetTransferRequest;
use App\Http\Requests\Transfers\ReceivedRequest;
use App\Models\Transfers\AssetTransfer;
use App\Services\API\TXIS\BudgetService;
use App\Services\Assets\AssetService;
use App\Services\Transfers\AssetTransferService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Yajra\DataTables\Facades\DataTables;

class TransferController extends Controller
{
    public function __construct(
        private AssetTransferService $service,
        private AssetService $assetService,
    ) {
    }

    public function index()
    {
        return view('transfers.transfer.index');
    }

    public function datatable()
    {
        $data = $this->service->datatable();
        return datatables()->of($data)
            ->editColumn('no_transaksi', function ($assetTransfer) {
                return $assetTransfer->no_transaksi;
            })
            ->editColumn('asset', function ($assetTransfer) {
                return $assetTransfer->asset?->kode;
            })
            ->editColumn('old_pic', function ($assetTransfer) {
                return $assetTransfer->oldPic?->nama_karyawan;
            })
            ->editColumn('new_pic', function ($assetTransfer) {
                return $assetTransfer->newPic?->nama_karyawan;
            })
            ->editColumn('status_transfer', function ($assetTransfer) {
                return $assetTransfer->status_transfer?->status?->badge();
            })
            ->editColumn('status', function ($assetTransfer) {
                return $assetTransfer->status?->badge();
            })
            ->editColumn('action', function ($assetTransfer) {
                return view('transfers.transfer.action', compact('assetTransfer'))->render();
            })
            ->rawColumns(['action', 'status', 'status_transfer'])
            ->make();
    }

    public function datatableAsset()
    {
        $data = $this->assetService->datatableForSelect();
        return datatables()->of($data)
            ->editColumn('nama', function ($asset) {
                return $asset->assetUnit?->unit?->model;
            })
            ->editColumn('merk_tipe_model', function ($asset) {
                return $asset->assetUnit?->brand;
            })
            ->editColumn('serial_number', function ($asset) {
                return $asset->assetUnit?->serial_number;
            })
            ->editColumn('nomor_asset', function ($asset) {
                return $asset->kode;
            })
            ->editColumn('niali_buku', function ($asset) {
                return Helper::formatRupiah($asset->nilai_sisa, true);
            })
            ->editColumn('kelengkapan', function ($asset) {
                return $asset->assetUnit?->spesification;
            })
            ->editColumn('action', function ($asset) {
                return '<button type="button" data-asset="' . $asset->id . '" class="btn btn-sm btn-primary select-asset">select</button>';
            })
            ->rawColumns(['action'])
            ->make();
    }

    public function datatableBudget($id, BudgetService $budgetService)
    {
        $assetTransfer = $this->service->finById($id);
        $data = Arr::get($budgetService->budgets($assetTransfer?->asset?->assetUnit?->kode, $assetTransfer->old_project)->json(), 'data');
        return DataTables::of($data)
            ->editColumn('remaining', function ($budget) {
                return Helper::formatRupiah((int)str($budget['remaining'])->replace(',', '')->value(), true);
            })
            ->editColumn('description', function ($budget) {
                return $budget['description_'];
            })
            ->make();
    }

    public function show(AssetTransfer $assetTransfer)
    {
        $assetTransfer->load(['asset.assetUnit.unit', 'asset.leasing', 'workflows' => function ($query) {
            $query->orderBy('sequence', 'ASC');
        }]);
        return view('transfers.transfer.show', [
            'assetTransfer' => AssetTransferData::from($assetTransfer),
        ]);
    }

    public function create(Request $request)
    {
        return view('transfers.transfer.create', [
            'assetTransfer' => AssetTransferData::from([
                'new_pic' => AuthHelper::getNik()
            ]),
            'asset' => $this->service->checkAsset($request)
        ]);
    }

    public function store(AssetTransferRequest $request)
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

    public function storeDraft(AssetTransferRequest $request)
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

    public function edit(AssetTransfer $assetTransfer)
    {
        try {
            $assetTransfer->loadMissing(['asset.assetUnit.unit', 'asset.leasing']);
            return view('transfers.transfer.edit', [
                'assetTransfer' => AssetTransferData::from($assetTransfer)
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function destroy(AssetTransfer $assetTransfer)
    {
        try {
            $this->service->delete($assetTransfer);
            return response()->json([
                'message' => 'Berhasil dihapus'
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function received(ReceivedRequest $request, AssetTransfer $assetTransfer)
    {
        try {
            $this->service->received($request, $assetTransfer);
            return response()->json([
                'message' => 'Berhasil di received'
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function employeeByAsset($asset)
    {
        try {
            $employee = AssetData::from($this->assetService->getById($asset))?->employee?->toArray();
            return response()->json($employee);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
