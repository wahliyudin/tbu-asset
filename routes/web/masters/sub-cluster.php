<?php

use App\Http\Controllers\Masters\SubClusterController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth'])->group(function () {
    Route::get('master/sub-clusters', [SubClusterController::class, 'index'])->name('masters.sub-clusters.index')->middleware('permission:sub_cluster_read');
    Route::post('master/sub-clusters/datatable', [SubClusterController::class, 'datatable'])->name('masters.sub-clusters.datatable')->middleware('permission:sub_cluster_read');
    Route::post('master/sub-clusters/store', [SubClusterController::class, 'store'])->name('masters.sub-clusters.store')->middleware('permission:sub_cluster_create');
    Route::post('master/sub-clusters/{subCluster}/edit', [SubClusterController::class, 'edit'])->name('masters.sub-clusters.edit')->middleware('permission:sub_cluster_update');
    Route::delete('master/sub-clusters/{subCluster}/destroy', [SubClusterController::class, 'destroy'])->name('masters.sub-clusters.destroy')->middleware('permission:sub_cluster_delete');

    Route::post('master/sub-clusters/data-for-select', [SubClusterController::class, 'dataForSelect'])->name('masters.sub-clusters.data-for-select');
});
