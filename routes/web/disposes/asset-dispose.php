<?php

use App\Http\Controllers\Disposes\DisposeController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth'])->group(function () {
    Route::get('asset-disposes', [DisposeController::class, 'index'])->name('asset-disposes.index')->middleware('permission:asset_dispose_read');
    Route::post('asset-disposes/datatable', [DisposeController::class, 'datatable'])->name('asset-disposes.datatable')->middleware('permission:asset_dispose_read');
    Route::post('asset-disposes/datatable-asset', [DisposeController::class, 'datatableAsset'])->name('asset-disposes.datatable-asset');
    Route::get('asset-disposes/create', [DisposeController::class, 'create'])->name('asset-disposes.create')->middleware('permission:asset_dispose_create');
    Route::post('asset-disposes/store', [DisposeController::class, 'store'])->name('asset-disposes.store')->middleware('permission:asset_dispose_create');
    Route::post('asset-disposes/store/draft', [DisposeController::class, 'storeDraft'])->name('asset-disposes.store.draft')->middleware('permission:asset_dispose_create');
    Route::get('asset-disposes/{assetDispose}/show', [DisposeController::class, 'show'])->name('asset-disposes.show')->middleware('permission:asset_dispose_read');
    Route::get('asset-disposes/{assetDispose}/edit', [DisposeController::class, 'edit'])->name('asset-disposes.edit')->middleware('permission:asset_dispose_update');
    Route::delete('asset-disposes/{assetDispose}/destroy', [DisposeController::class, 'destroy'])->name('asset-disposes.destroy')->middleware('permission:asset_dispose_delete');
});
