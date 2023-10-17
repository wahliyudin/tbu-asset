<?php

use App\Http\Controllers\Masters\ClusterController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth'])->group(function () {
    Route::get('master/clusters', [ClusterController::class, 'index'])->name('masters.clusters.index')->middleware('permission:cluster_read');
    Route::post('master/clusters/datatable', [ClusterController::class, 'datatable'])->name('masters.clusters.datatable')->middleware('permission:cluster_read');
    Route::post('master/clusters/store', [ClusterController::class, 'store'])->name('masters.clusters.store')->middleware('permission:cluster_create');
    Route::post('master/clusters/{cluster}/edit', [ClusterController::class, 'edit'])->name('masters.clusters.edit')->middleware('permission:cluster_update');
    Route::delete('master/clusters/{cluster}/destroy', [ClusterController::class, 'destroy'])->name('masters.clusters.destroy')->middleware('permission:cluster_delete');
});
