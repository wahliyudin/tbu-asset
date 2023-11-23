<?php

use App\Http\Controllers\Reports\CerController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth'])->group(function () {
    Route::get('reports/asset-requests', [CerController::class, 'index'])->name('reports.asset-requests.index');
    Route::post('reports/asset-requests/datatable', [CerController::class, 'datatable'])->name('reports.asset-requests.datatable');
    Route::post('reports/asset-requests/export', [CerController::class, 'export'])->name('reports.asset-requests.export');
});
