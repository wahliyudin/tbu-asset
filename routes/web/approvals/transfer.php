<?php

use App\Http\Controllers\Approval\ApprovalTransferController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth'])->group(function () {
    Route::get('approvals/transfers', [ApprovalTransferController::class, 'index'])->name('approvals.transfers.index')->middleware('permission:asset_transfer_approv|asset_transfer_reject');
    Route::post('approvals/transfers/datatable', [ApprovalTransferController::class, 'datatable'])->name('approvals.transfers.datatable')->middleware('permission:asset_transfer_approv|asset_transfer_reject');
    Route::get('approvals/transfers/{assetTransfer}/show', [ApprovalTransferController::class, 'show'])->name('approvals.transfers.show')->middleware('permission:asset_transfer_approv|asset_transfer_reject');
    Route::post('approvals/transfers/{assetTransfer}/approv', [ApprovalTransferController::class, 'approv'])->name('approvals.transfers.approv')->middleware('permission:asset_transfer_approv|asset_transfer_reject');
    Route::post('approvals/transfers/{assetTransfer}/reject', [ApprovalTransferController::class, 'reject'])->name('approvals.transfers.reject')->middleware('permission:asset_transfer_approv|asset_transfer_reject');
});
