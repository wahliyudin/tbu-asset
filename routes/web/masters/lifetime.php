<?php

use App\Http\Controllers\Masters\LifetimeController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth'])->group(function () {
    Route::get('master/lifetimes', [LifetimeController::class, 'index'])->name('masters.lifetimes.index')->middleware('permission:lifetime_read');
    Route::post('master/lifetimes/datatable', [LifetimeController::class, 'datatable'])->name('masters.lifetimes.datatable')->middleware('permission:lifetime_read');
    Route::post('master/lifetimes/store', [LifetimeController::class, 'store'])->name('masters.lifetimes.store')->middleware('permission:lifetime_create');
    Route::post('master/lifetimes/{lifetime}/edit', [LifetimeController::class, 'edit'])->name('masters.lifetimes.edit')->middleware('permission:lifetime_update');
    Route::delete('master/lifetimes/{lifetime}/destroy', [LifetimeController::class, 'destroy'])->name('masters.lifetimes.destroy')->middleware('permission:lifetime_delete');

    Route::post('master/lifetimes/data-for-select', [LifetimeController::class, 'dataForSelect'])->name('masters.lifetimes.data-for-select');
});
