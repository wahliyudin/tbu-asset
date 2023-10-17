<?php

use App\Http\Controllers\Cers\RegisterController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth'])->group(function () {
    Route::get('asset-registers', [RegisterController::class, 'index'])->name('asset-registers.index');
    Route::post('asset-registers/datatable', [RegisterController::class, 'datatable'])->name('asset-registers.datatable');
    Route::get('asset-registers/{cerItem}/register', [RegisterController::class, 'create'])->name('asset-registers.create');
    Route::post('asset-registers/{cerItem}/register', [RegisterController::class, 'store'])->name('asset-registers.store');
    Route::get('asset-registers/{id}/history', [RegisterController::class, 'history'])->name('asset-registers.history');
});
