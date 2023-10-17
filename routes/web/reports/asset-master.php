<?php

use App\Http\Controllers\Reports\AssetMasterController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth'])->group(function () {
    Route::get('reports/asset-masters', [AssetMasterController::class, 'index'])->name('reports.asset-masters.index');
    Route::post('reports/asset-masters/datatable', [AssetMasterController::class, 'datatable'])->name('reports.asset-masters.datatable');
    Route::post('reports/asset-masters/export', [AssetMasterController::class, 'export'])->name('reports.asset-masters.export');
});
