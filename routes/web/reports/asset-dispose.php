<?php

use App\Http\Controllers\Reports\AssetDisposeController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth'])->group(function () {
    Route::get('reports/asset-disposes', [AssetDisposeController::class, 'index'])->name('reports.asset-disposes.index');
    Route::post('reports/asset-disposes/datatable', [AssetDisposeController::class, 'datatable'])->name('reports.asset-disposes.datatable');
    Route::post('reports/asset-disposes/export', [AssetDisposeController::class, 'export'])->name('reports.asset-disposes.export');
});
