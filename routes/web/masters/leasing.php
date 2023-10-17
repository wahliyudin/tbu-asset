<?php

use App\Http\Controllers\Masters\LeasingController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth'])->group(function () {
    Route::get('master/leasings', [LeasingController::class, 'index'])->name('masters.leasings.index')->middleware('permission:leasing_read');
    Route::post('master/leasings/datatable', [LeasingController::class, 'datatable'])->name('masters.leasings.datatable')->middleware('permission:leasing_read');
    Route::post('master/leasings/store', [LeasingController::class, 'store'])->name('masters.leasings.store')->middleware('permission:leasing_create');
    Route::post('master/leasings/{leasing}/edit', [LeasingController::class, 'edit'])->name('masters.leasings.edit')->middleware('permission:leasing_update');
    Route::delete('master/leasings/{leasing}/destroy', [LeasingController::class, 'destroy'])->name('masters.leasings.destroy')->middleware('permission:leasing_delete');
});
