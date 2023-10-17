<?php

use App\Http\Controllers\Assets\AssetMasterController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth'])->group(function () {
    Route::get('asset-masters', [AssetMasterController::class, 'index'])->name('asset-masters.index')->middleware('permission:asset_master_read');
    Route::post('asset-masters/datatable', [AssetMasterController::class, 'datatable'])->name('asset-masters.datatable')->middleware('permission:asset_master_read');
    Route::post('asset-masters/store', [AssetMasterController::class, 'store'])->name('asset-masters.store')->middleware('permission:asset_master_create|asset_master_update');
    Route::get('asset-masters/{kode}/show', [AssetMasterController::class, 'show'])->name('asset-masters.show')->middleware('permission:asset_master_read');
    Route::post('asset-masters/{asset}/edit', [AssetMasterController::class, 'edit'])->name('asset-masters.edit')->middleware('permission:asset_master_update');
    Route::delete('asset-masters/{asset}/destroy', [AssetMasterController::class, 'destroy'])->name('asset-masters.destroy')->middleware('permission:asset_master_delete');
    Route::post('asset-masters/import', [AssetMasterController::class, 'import'])->name('asset-masters.import')->middleware('permission:asset_master_create');
    Route::get('asset-masters/format', [AssetMasterController::class, 'format'])->name('asset-masters.format')->middleware('permission:asset_master_create');
    Route::post('asset-masters/batch', [AssetMasterController::class, 'batch'])->name('asset-masters.batch');
    Route::post('asset-masters/bulk', [AssetMasterController::class, 'bulk'])->name('asset-masters.bulk');
    Route::get('asset-masters/{id}/next-id-asset-unit', [AssetMasterController::class, 'nextIdAssetUnit'])->name('asset-masters.next-id-asset-unit');
});
