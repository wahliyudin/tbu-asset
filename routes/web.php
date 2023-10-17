<?php

use App\Http\Controllers\Assets\AssetMasterController;
use App\Http\Controllers\GlobalController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SSO\AuthController;
use App\Http\Controllers\ThirdParty\TXIS\BudgetController;
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

Route::get('sso/login', [AuthController::class, 'login'])->name('sso.login');
Route::get('sso/callback', [AuthController::class, 'callback'])->name('sso.callback');
Auth::routes();
Route::get('asset-masters/{kode}/show-scan', [AssetMasterController::class, 'showScan'])->name('asset-masters.show-scan');
Route::post('asset-masters/depreciation', [AssetMasterController::class, 'depreciation'])->name('asset-masters.depreciation');
Route::middleware(['auth'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/home/charts', [HomeController::class, 'charts'])->name('home.charts');
    Route::post('budgets/datatable', [BudgetController::class, 'datatable'])->name('budgets.datatable');
    Route::get('global/total-approvals', [GlobalController::class, 'totalApprovals'])->name('global.total-approvals');
});
