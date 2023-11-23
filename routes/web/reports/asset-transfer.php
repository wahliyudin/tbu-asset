<?php

use App\Http\Controllers\Reports\AssetTransferController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth'])->group(function () {
    Route::get('reports/asset-transfers', [AssetTransferController::class, 'index'])->name('reports.asset-transfers.index');
    Route::post('reports/asset-transfers/datatable', [AssetTransferController::class, 'datatable'])->name('reports.asset-transfers.datatable');
    Route::post('reports/asset-transfers/export', [AssetTransferController::class, 'export'])->name('reports.asset-transfers.export');
});
