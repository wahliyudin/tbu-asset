<?php

use App\Http\Controllers\Settings\SettingApprovalController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth'])->group(function () {
    Route::get('settings/approval', [SettingApprovalController::class, 'index'])->name('settings.approval.index')->middleware('permission:approval_read');
    Route::post('settings/approval/store', [SettingApprovalController::class, 'store'])->name('settings.approval.store')->middleware('permission:approval_update');
});
