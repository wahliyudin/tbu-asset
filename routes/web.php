<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Masters\CatalogController;
use App\Http\Controllers\Masters\CategoryController;
use App\Http\Controllers\Masters\ClusterController;
use App\Http\Controllers\Masters\SubClusterController;
use App\Http\Controllers\Masters\SubClusterItemController;
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

    Route::get('clusters', [ClusterController::class, 'index'])->name('clusters.index');
    Route::post('clusters/datatable', [ClusterController::class, 'datatable'])->name('clusters.datatable');
    Route::post('clusters/store', [ClusterController::class, 'store'])->name('clusters.store');
    Route::post('clusters/{cluster}/edit', [ClusterController::class, 'edit'])->name('clusters.edit');
    Route::delete('clusters/{cluster}/destroy', [ClusterController::class, 'destroy'])->name('clusters.destroy');

    Route::get('sub-clusters', [SubClusterController::class, 'index'])->name('sub-clusters.index');
    Route::post('sub-clusters/datatable', [SubClusterController::class, 'datatable'])->name('sub-clusters.datatable');
    Route::post('sub-clusters/store', [SubClusterController::class, 'store'])->name('sub-clusters.store');
    Route::post('sub-clusters/{subCluster}/edit', [SubClusterController::class, 'edit'])->name('sub-clusters.edit');
    Route::delete('sub-clusters/{subCluster}/destroy', [SubClusterController::class, 'destroy'])->name('sub-clusters.destroy');

    Route::get('sub-cluster-items', [SubClusterItemController::class, 'index'])->name('sub-cluster-items.index');
    Route::post('sub-cluster-items/datatable', [SubClusterItemController::class, 'datatable'])->name('sub-cluster-items.datatable');
    Route::post('sub-cluster-items/store', [SubClusterItemController::class, 'store'])->name('sub-cluster-items.store');
    Route::post('sub-cluster-items/{subClusterItem}/edit', [SubClusterItemController::class, 'edit'])->name('sub-cluster-items.edit');
    Route::delete('sub-cluster-items/{subClusterItem}/destroy', [SubClusterItemController::class, 'destroy'])->name('sub-cluster-items.destroy');

    Route::get('catalogs', [CatalogController::class, 'index'])->name('catalogs.index');
    Route::post('catalogs/datatable', [CatalogController::class, 'datatable'])->name('catalogs.datatable');
    Route::post('catalogs/store', [CatalogController::class, 'store'])->name('catalogs.store');
    Route::post('catalogs/{catalog}/edit', [CatalogController::class, 'edit'])->name('catalogs.edit');
    Route::delete('catalogs/{catalog}/destroy', [CatalogController::class, 'destroy'])->name('catalogs.destroy');
});