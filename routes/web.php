<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Master\CategoryController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    if (auth()->guard()) {
        return to_route('login');
    }
    return to_route('home');
});

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::get('categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::post('categories/datatable', [CategoryController::class, 'datatable'])->name('categories.datatable');
    Route::post('categories/store', [CategoryController::class, 'store'])->name('categories.store');
    Route::post('categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::delete('categories/{category}/destroy', [CategoryController::class, 'destroy'])->name('categories.destroy');
});