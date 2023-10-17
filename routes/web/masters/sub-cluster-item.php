<?php

use App\Http\Controllers\Masters\SubClusterItemController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth'])->group(function () {
    Route::get('master/sub-cluster-items', [SubClusterItemController::class, 'index'])->name('masters.sub-cluster-items.index')->middleware('permission:sub_cluster_item_read');
    Route::post('master/sub-cluster-items/datatable', [SubClusterItemController::class, 'datatable'])->name('masters.sub-cluster-items.datatable')->middleware('permission:sub_cluster_item_read');
    Route::post('master/sub-cluster-items/store', [SubClusterItemController::class, 'store'])->name('masters.sub-cluster-items.store')->middleware('permission:sub_cluster_item_create');
    Route::post('master/sub-cluster-items/{subClusterItem}/edit', [SubClusterItemController::class, 'edit'])->name('masters.sub-cluster-items.edit')->middleware('permission:sub_cluster_item_update');
    Route::delete('master/sub-cluster-items/{subClusterItem}/destroy', [SubClusterItemController::class, 'destroy'])->name('masters.sub-cluster-items.destroy')->middleware('permission:sub_cluster_item_delete');
});
