<?php

use App\Http\Controllers\Cers\CerController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth'])->group(function () {
    Route::get('asset-requests', [CerController::class, 'index'])->name('asset-requests.index')->middleware('permission:asset_request_read');
    Route::post('asset-requests/datatable', [CerController::class, 'datatable'])->name('asset-requests.datatable')->middleware('permission:asset_request_read');
    Route::post('asset-requests/datatable-asset-idle', [CerController::class, 'datatableAssetIdle'])->name('asset-requests.datatable-asset-idle');
    Route::get('asset-requests/create', [CerController::class, 'create'])->name('asset-requests.create')->middleware('permission:asset_request_create');
    Route::post('asset-requests/store', [CerController::class, 'store'])->name('asset-requests.store')->middleware('permission:asset_request_create');
    Route::post('asset-requests/store/draft', [CerController::class, 'storeDraft'])->name('asset-requests.store.draft')->middleware('permission:asset_request_create');
    Route::get('asset-requests/{cer}/show', [CerController::class, 'show'])->name('asset-requests.show')->middleware('permission:asset_request_read');
    Route::get('asset-requests/{cer}/edit', [CerController::class, 'edit'])->name('asset-requests.edit')->middleware('permission:asset_request_update');
    Route::delete('asset-requests/{cer}/destroy', [CerController::class, 'destroy'])->name('asset-requests.destroy')->middleware('permission:asset_request_delete');
});
