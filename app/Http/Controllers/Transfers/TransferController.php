<?php

namespace App\Http\Controllers\Transfers;

use App\DataTransferObjects\Assets\AssetData;
use App\DataTransferObjects\Transfers\AssetTransferData;
use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Transfers\AssetTransferRequest;
use App\Models\Assets\Asset;
use App\Models\Transfers\AssetTransfer;
use App\Services\Assets\AssetService;
use App\Services\Transfers\AssetTransferService;
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
        return DataTables::of($this->service->allToAssetTransferData())
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
            ->editColumn('status', function (AssetTransferData $assetTransfer) {
                return $assetTransfer->status->badge();
            })
            ->editColumn('action', function (AssetTransferData $assetTransfer) {
                return view('transfers.transfer.action', compact('assetTransfer'))->render();
            })
            ->rawColumns(['action', 'status'])
            ->make();
    }

    public function datatableAsset()
    {
        return DataTables::of($this->assetService->all())
            ->editColumn('nama', function (Asset $asset) {
                return 'example';
            })
            ->editColumn('merk_tipe_model', function (Asset $asset) {
                return $asset->unit?->brand;
            })
            ->editColumn('serial_number', function (Asset $asset) {
                return $asset->unit?->serial_number;
            })
            ->editColumn('nomor_asset', function (Asset $asset) {
                return $asset->kode;
            })
            ->editColumn('niali_buku', function (Asset $asset) {
                return Helper::formatRupiah($asset->leasing?->harga_beli, true);
            })
            ->editColumn('kelengkapan', function (Asset $asset) {
                return $asset->unit?->spesification;
            })
            ->editColumn('action', function (Asset $asset) {
                return '<button type="button" data-asset="' . $asset->getKey() . '" class="btn btn-sm btn-primary select-asset">select</button>';
            })
            ->rawColumns(['action'])
            ->make();
    }

    public function create()
    {
        return view('transfers.transfer.create', [
            'assetTransfer' => AssetTransferData::from([
                'new_pic' => auth()->user()->nik
            ])
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

    public function edit(AssetTransfer $assetTransfer)
    {
        try {
            $assetTransfer->loadMissing(['asset.unit', 'asset.leasing']);
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

    public function employeeByAsset($asset)
    {
        try {
            return response()->json(AssetData::from($this->assetService->getById($asset))->employee->toArray());
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
