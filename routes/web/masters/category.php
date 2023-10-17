<?php

use App\Http\Controllers\Masters\CategoryController;
use Illuminate\Support\Facades\Route;



Route::middleware(['auth'])->group(function () {
    Route::get('master/categories', [CategoryController::class, 'index'])->name('masters.categories.index')->middleware('permission:category_read');
    Route::post('master/categories/datatable', [CategoryController::class, 'datatable'])->name('masters.categories.datatable')->middleware('permission:category_read');
    Route::post('master/categories/store', [CategoryController::class, 'store'])->name('masters.categories.store')->middleware('permission:category_create');
    Route::post('master/categories/{category}/edit', [CategoryController::class, 'edit'])->name('masters.categories.edit')->middleware('permission:category_update');
    Route::delete('master/categories/{category}/destroy', [CategoryController::class, 'destroy'])->name('masters.categories.destroy')->middleware('permission:category_delete');
});
