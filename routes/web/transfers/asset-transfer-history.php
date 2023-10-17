<?php

use App\Http\Controllers\Transfers\HistoryController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth'])->group(function () {
    Route::get('asset-transfers/histories', [HistoryController::class, 'index'])->name('asset-transfers.histories.index');
    Route::post('asset-transfers/histories/datatable', [HistoryController::class, 'datatable'])->name('asset-transfers.histories.datatable');
    Route::get('asset-transfers/histories/{asset}/detail', [HistoryController::class, 'detail'])->name('asset-transfers.histories.detail');
    Route::post('asset-transfers/histories/{asset}/show', [HistoryController::class, 'show'])->name('asset-transfers.histories.show');
});
