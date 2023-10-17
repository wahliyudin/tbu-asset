<?php

use App\Http\Controllers\Masters\CatalogController;
use Illuminate\Support\Facades\Route;



Route::middleware(['auth'])->group(function () {
    Route::get('master/catalogs', [CatalogController::class, 'index'])->name('masters.catalogs.index')->middleware('permission:catalog_read');
    Route::post('master/catalogs/datatable', [CatalogController::class, 'datatable'])->name('masters.catalogs.datatable')->middleware('permission:catalog_read');
    Route::post('master/catalogs/store', [CatalogController::class, 'store'])->name('masters.catalogs.store')->middleware('permission:catalog_create');
    Route::post('master/catalogs/{catalog}/edit', [CatalogController::class, 'edit'])->name('masters.catalogs.edit')->middleware('permission:catalog_update');
    Route::delete('master/catalogs/{catalog}/destroy', [CatalogController::class, 'destroy'])->name('masters.catalogs.destroy')->middleware('permission:catalog_delete');
});
