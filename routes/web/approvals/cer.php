<?php

use App\Http\Controllers\Approval\ApprovalCerController;
use Illuminate\Support\Facades\Route;



Route::middleware(['auth'])->group(function () {
    Route::get('approvals/cers', [ApprovalCerController::class, 'index'])->name('approvals.cers.index')->middleware('permission:asset_request_approv|asset_request_reject');
    Route::post('approvals/cers/datatable', [ApprovalCerController::class, 'datatable'])->name('approvals.cers.datatable')->middleware('permission:asset_request_approv|asset_request_reject');
    Route::get('approvals/cers/{cer}/show', [ApprovalCerController::class, 'show'])->name('approvals.cers.show')->middleware('permission:asset_request_approv|asset_request_reject');
    Route::post('approvals/cers/{cer}/approv', [ApprovalCerController::class, 'approv'])->name('approvals.cers.approv')->middleware('permission:asset_request_approv|asset_request_reject');
    Route::post('approvals/cers/{cer}/reject', [ApprovalCerController::class, 'reject'])->name('approvals.cers.reject')->middleware('permission:asset_request_approv|asset_request_reject');
});
