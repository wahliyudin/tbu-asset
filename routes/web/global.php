<?php

use App\Http\Controllers\GlobalController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth'])->group(function () {
    Route::post('global/projects/data-for-select', [GlobalController::class, 'projectDataForSelect'])->name('asset-transfers.projects.data-for-select');
    Route::post('global/employees/data-for-select', [GlobalController::class, 'employeeDataForSelect'])->name('asset-transfers.employees.data-for-select');
});
