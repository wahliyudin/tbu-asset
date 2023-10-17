<?php

use App\Http\Controllers\Masters\UomController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth'])->group(function () {
    Route::get('master/uoms', [UomController::class, 'index'])->name('masters.uoms.index')->middleware('permission:uom_read');
    Route::post('master/uoms/datatable', [UomController::class, 'datatable'])->name('masters.uoms.datatable')->middleware('permission:uom_read');
    Route::post('master/uoms/store', [UomController::class, 'store'])->name('masters.uoms.store')->middleware('permission:uom_create');
    Route::post('master/uoms/{uom}/edit', [UomController::class, 'edit'])->name('masters.uoms.edit')->middleware('permission:uom_update');
    Route::delete('master/uoms/{uom}/destroy', [UomController::class, 'destroy'])->name('masters.uoms.destroy')->middleware('permission:uom_delete');
});
