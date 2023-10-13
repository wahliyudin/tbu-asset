<?php

namespace App\Http\Controllers\Transfers;

use App\DataTransferObjects\Assets\AssetData;
use App\DataTransferObjects\Transfers\AssetTransferData;
use App\Enums\Transfers\Transfer\Status;
use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Transfers\AssetTransferRequest;
use App\Http\Requests\Transfers\ReceivedRequest;
use App\Models\Transfers\AssetTransfer;
use App\Services\Assets\AssetService;
use App\Services\Transfers\AssetTransferService;
use Illuminate\Http\Request;
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

    public function datatable(Request $request)
    {
        return DataTables::of($this->service->allToAssetTransferData($request->get('search')))
            ->editColumn('no_transaksi', function (AssetTransferData $assetTransfer) {
                return $assetTransfer->no_transaksi;
            })
            ->editColumn('asset', function (AssetTransferData $assetTransfer) {
                return $assetTransfer->asset?->kode;
            })
            ->editColumn('old_pic', function (AssetTransferData $assetTransfer) {
                return $assetTransfer->oldPic?->nama_karyawan;
            })
            ->editColumn('new_pic', function (AssetTransferData $assetTransfer) {
                return $assetTransfer->newPic?->nama_karyawan;
            })
            ->editColumn('status_transfer', function (AssetTransferData $assetTransfer) {
                return $assetTransfer->status_transfer?->status?->badge();
            })
            ->editColumn('status', function (AssetTransferData $assetTransfer) {
                return $assetTransfer->status?->badge();
            })
            ->editColumn('action', function (AssetTransferData $assetTransfer) {
                return view('transfers.transfer.action', compact('assetTransfer'))->render();
            })
            ->rawColumns(['action', 'status', 'status_transfer'])
            ->make();
    }

    public function datatableAsset(Request $request)
    {
        return DataTables::of($this->assetService->all($request->get('search')))
            ->editColumn('nama', function ($asset) {
                return $asset->_source->asset_unit?->unit?->model;
            })
            ->editColumn('merk_tipe_model', function ($asset) {
                return $asset->_source->asset_unit?->brand;
            })
            ->editColumn('serial_number', function ($asset) {
                return $asset->_source->asset_unit?->serial_number;
            })
            ->editColumn('nomor_asset', function ($asset) {
                return $asset->_source->kode;
            })
            ->editColumn('niali_buku', function ($asset) {
                return Helper::formatRupiah($asset->_source->nilai_sisa, true);
            })
            ->editColumn('kelengkapan', function ($asset) {
                return $asset->_source->asset_unit?->spesification;
            })
            ->editColumn('action', function ($asset) {
                return '<button type="button" data-asset="' . $asset->_id . '" class="btn btn-sm btn-primary select-asset">select</button>';
            })
            ->rawColumns(['action'])
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
        $nik = auth()->user()?->nik;
        return view('transfers.transfer.create', [
            'assetTransfer' => AssetTransferData::from([
                'new_pic' => $nik
            ]),
            'asset' => $this->service->checkAsset($request),
            'noTransaksi' => $this->service->nextNoTransfer($nik)
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
