<?php

use App\Http\Controllers\Masters\UnitController;
use Illuminate\Support\Facades\Route;



Route::middleware(['auth'])->group(function () {
    Route::get('master/units', [UnitController::class, 'index'])->name('masters.units.index')->middleware('permission:unit_read');
    Route::post('master/units/datatable', [UnitController::class, 'datatable'])->name('masters.units.datatable')->middleware('permission:unit_read');
    Route::post('master/units/store', [UnitController::class, 'store'])->name('masters.units.store')->middleware('permission:unit_create');
    Route::post('master/units/{unit}/edit', [UnitController::class, 'edit'])->name('masters.units.edit')->middleware('permission:unit_update');
    Route::delete('master/units/{unit}/destroy', [UnitController::class, 'destroy'])->name('masters.units.destroy')->middleware('permission:unit_delete');

    Route::post('master/units/data-for-select', [UnitController::class, 'dataForSelect'])->name('masters.units.data-for-select');
});
