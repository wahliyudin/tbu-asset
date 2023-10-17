<?php

use App\Http\Controllers\Masters\DealerController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth'])->group(function () {
    Route::get('master/dealers', [DealerController::class, 'index'])->name('masters.dealers.index')->middleware('permission:dealer_read');
    Route::post('master/dealers/datatable', [DealerController::class, 'datatable'])->name('masters.dealers.datatable')->middleware('permission:dealer_read');
    Route::post('master/dealers/store', [DealerController::class, 'store'])->name('masters.dealers.store')->middleware('permission:dealer_create');
    Route::post('master/dealers/{dealer}/edit', [DealerController::class, 'edit'])->name('masters.dealers.edit')->middleware('permission:dealer_update');
    Route::delete('master/dealers/{dealer}/destroy', [DealerController::class, 'destroy'])->name('masters.dealers.destroy')->middleware('permission:dealer_delete');
});
