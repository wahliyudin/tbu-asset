<?php

use App\Http\Controllers\Settings\AccessPermissionController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth'])->group(function () {
    Route::get('settings/access-permission', [AccessPermissionController::class, 'index'])->name('settings.access-permission.index')->middleware('permission:access_permission_read');
    Route::post('settings/access-permission/datatable', [AccessPermissionController::class, 'datatable'])->name('settings.access-permission.datatable')->middleware('permission:access_permission_read');
    Route::get('settings/access-permission/{user:nik}/edit', [AccessPermissionController::class, 'edit'])->name('settings.access-permission.edit')->middleware('permission:access_permission_update');
    Route::put('settings/access-permission/{user}/update', [AccessPermissionController::class, 'update'])->name('settings.access-permission.update')->middleware('permission:access_permission_update');
});
