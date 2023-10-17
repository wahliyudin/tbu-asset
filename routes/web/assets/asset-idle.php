<?php

use App\Http\Controllers\Assets\AssetIdleController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth'])->group(function () {
    Route::get('asset-idles', [AssetIdleController::class, 'index'])->name('asset-idles.index')->middleware('permission:asset_idle_read');
    Route::post('asset-idles/datatable', [AssetIdleController::class, 'datatable'])->name('asset-idles.datatable')->middleware('permission:asset_idle_read');
});
