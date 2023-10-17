<?php

use App\Http\Controllers\Masters\ActivityController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth'])->group(function () {
    Route::get('master/activities', [ActivityController::class, 'index'])->name('masters.activities.index')->middleware('permission:activity_read');
    Route::post('master/activities/datatable', [ActivityController::class, 'datatable'])->name('masters.activities.datatable')->middleware('permission:activity_read');
    Route::post('master/activities/store', [ActivityController::class, 'store'])->name('masters.activities.store')->middleware('permission:activity_create');
    Route::post('master/activities/{activity}/edit', [ActivityController::class, 'edit'])->name('masters.activities.edit')->middleware('permission:activity_update');
    Route::delete('master/activities/{activity}/destroy', [ActivityController::class, 'destroy'])->name('masters.activities.destroy')->middleware('permission:activity_delete');

    Route::post('master/activities/data-for-select', [ActivityController::class, 'dataForSelect'])->name('masters.activities.data-for-select');
});
