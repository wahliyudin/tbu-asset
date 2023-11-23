<?php

use App\Http\Controllers\Transfers\TransferController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth'])->group(function () {
    Route::get('asset-transfers', [TransferController::class, 'index'])->name('asset-transfers.index')->middleware('permission:asset_transfer_read');
    Route::post('asset-transfers/datatable', [TransferController::class, 'datatable'])->name('asset-transfers.datatable')->middleware('permission:asset_transfer_read');
    Route::post('asset-transfers/datatable-asset', [TransferController::class, 'datatableAsset'])->name('asset-transfers.datatable-asset');
    Route::get('asset-transfers/create', [TransferController::class, 'create'])->name('asset-transfers.create')->middleware('permission:asset_transfer_create');
    Route::post('asset-transfers/store', [TransferController::class, 'store'])->name('asset-transfers.store')->middleware('permission:asset_transfer_create');
    Route::post('asset-transfers/store/draft', [TransferController::class, 'storeDraft'])->name('asset-transfers.store.draft')->middleware('permission:asset_transfer_create');
    Route::get('asset-transfers/{assetTransfer}/show', [TransferController::class, 'show'])->name('asset-transfers.show')->middleware('permission:asset_transfer_read');
    Route::get('asset-transfers/{assetTransfer}/edit', [TransferController::class, 'edit'])->name('asset-transfers.edit')->middleware('permission:asset_transfer_update');
    Route::delete('asset-transfers/{assetTransfer}/destroy', [TransferController::class, 'destroy'])->name('asset-transfers.destroy')->middleware('permission:asset_transfer_delete');
    Route::post('asset-transfers/{assetTransfer}/received', [TransferController::class, 'received'])->name('asset-transfers.received');
    Route::get('asset-transfers/{asset}/employee', [TransferController::class, 'employeeByAsset'])->name('asset-transfers.employee-by-asset');
    Route::post('asset-transfers/{transfer}/datatable-budget', [TransferController::class, 'datatableBudget'])->name('asset-transfers.datatable-budget');
    Route::get('asset-transfers/{assetTransfer}/download-file-bast', [TransferController::class, 'downloadFileBast'])->name('asset-transfers.download-file-bast');
});
