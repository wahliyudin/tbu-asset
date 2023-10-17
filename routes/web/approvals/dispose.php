<?php

use App\Http\Controllers\Approval\ApprovalDisposeController;
use Illuminate\Support\Facades\Route;



Route::middleware(['auth'])->group(function () {
    Route::get('approvals/disposes', [ApprovalDisposeController::class, 'index'])->name('approvals.disposes.index')->middleware('permission:asset_dispose_approv|asset_dispose_reject');
    Route::post('approvals/disposes/datatable', [ApprovalDisposeController::class, 'datatable'])->name('approvals.disposes.datatable')->middleware('permission:asset_dispose_approv|asset_dispose_reject');
    Route::get('approvals/disposes/{assetDispose}/show', [ApprovalDisposeController::class, 'show'])->name('approvals.disposes.show')->middleware('permission:asset_dispose_approv|asset_dispose_reject');
    Route::post('approvals/disposes/{assetDispose}/approv', [ApprovalDisposeController::class, 'approv'])->name('approvals.disposes.approv')->middleware('permission:asset_dispose_approv|asset_dispose_reject');
    Route::post('approvals/disposes/{assetDispose}/reject', [ApprovalDisposeController::class, 'reject'])->name('approvals.disposes.reject')->middleware('permission:asset_dispose_approv|asset_dispose_reject');
});
