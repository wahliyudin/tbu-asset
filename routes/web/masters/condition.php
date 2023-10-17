<?php

use App\Http\Controllers\Masters\ConditionController;
use Illuminate\Support\Facades\Route;



Route::middleware(['auth'])->group(function () {
    Route::get('master/conditions', [ConditionController::class, 'index'])->name('masters.conditions.index')->middleware('permission:condition_read');
    Route::post('master/conditions/datatable', [ConditionController::class, 'datatable'])->name('masters.conditions.datatable')->middleware('permission:condition_read');
    Route::post('master/conditions/store', [ConditionController::class, 'store'])->name('masters.conditions.store')->middleware('permission:condition_create');
    Route::post('master/conditions/{condition}/edit', [ConditionController::class, 'edit'])->name('masters.conditions.edit')->middleware('permission:condition_update');
    Route::delete('master/conditions/{condition}/destroy', [ConditionController::class, 'destroy'])->name('masters.conditions.destroy')->middleware('permission:condition_delete');
});
