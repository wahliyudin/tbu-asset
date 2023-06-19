<?php

use App\Http\Controllers\AssetMasterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Masters\CatalogController;
use App\Http\Controllers\Masters\CategoryController;
use App\Http\Controllers\Masters\ClusterController;
use App\Http\Controllers\Masters\DealerController;
use App\Http\Controllers\Masters\LeasingController;
use App\Http\Controllers\Masters\SubClusterController;
use App\Http\Controllers\Masters\SubClusterItemController;
use App\Http\Controllers\Masters\UnitController;
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

    Route::get('master/categories', [CategoryController::class, 'index'])->name('master.categories.index');
    Route::post('master/categories/datatable', [CategoryController::class, 'datatable'])->name('master.categories.datatable');
    Route::post('master/categories/store', [CategoryController::class, 'store'])->name('master.categories.store');
    Route::post('master/categories/{category}/edit', [CategoryController::class, 'edit'])->name('master.categories.edit');
    Route::delete('master/categories/{category}/destroy', [CategoryController::class, 'destroy'])->name('master.categories.destroy');

    Route::get('master/clusters', [ClusterController::class, 'index'])->name('master.clusters.index');
    Route::post('master/clusters/datatable', [ClusterController::class, 'datatable'])->name('master.clusters.datatable');
    Route::post('master/clusters/store', [ClusterController::class, 'store'])->name('master.clusters.store');
    Route::post('master/clusters/{cluster}/edit', [ClusterController::class, 'edit'])->name('master.clusters.edit');
    Route::delete('master/clusters/{cluster}/destroy', [ClusterController::class, 'destroy'])->name('master.clusters.destroy');

    Route::get('master/sub-clusters', [SubClusterController::class, 'index'])->name('master.sub-clusters.index');
    Route::post('master/sub-clusters/datatable', [SubClusterController::class, 'datatable'])->name('master.sub-clusters.datatable');
    Route::post('master/sub-clusters/store', [SubClusterController::class, 'store'])->name('master.sub-clusters.store');
    Route::post('master/sub-clusters/{subCluster}/edit', [SubClusterController::class, 'edit'])->name('master.sub-clusters.edit');
    Route::delete('master/sub-clusters/{subCluster}/destroy', [SubClusterController::class, 'destroy'])->name('master.sub-clusters.destroy');

    Route::get('master/sub-cluster-items', [SubClusterItemController::class, 'index'])->name('master.sub-cluster-items.index');
    Route::post('master/sub-cluster-items/datatable', [SubClusterItemController::class, 'datatable'])->name('master.sub-cluster-items.datatable');
    Route::post('master/sub-cluster-items/store', [SubClusterItemController::class, 'store'])->name('master.sub-cluster-items.store');
    Route::post('master/sub-cluster-items/{subClusterItem}/edit', [SubClusterItemController::class, 'edit'])->name('master.sub-cluster-items.edit');
    Route::delete('master/sub-cluster-items/{subClusterItem}/destroy', [SubClusterItemController::class, 'destroy'])->name('master.sub-cluster-items.destroy');

    Route::get('master/catalogs', [CatalogController::class, 'index'])->name('master.catalogs.index');
    Route::post('master/catalogs/datatable', [CatalogController::class, 'datatable'])->name('master.catalogs.datatable');
    Route::post('master/catalogs/store', [CatalogController::class, 'store'])->name('master.catalogs.store');
    Route::post('master/catalogs/{catalog}/edit', [CatalogController::class, 'edit'])->name('master.catalogs.edit');
    Route::delete('master/catalogs/{catalog}/destroy', [CatalogController::class, 'destroy'])->name('master.catalogs.destroy');

    Route::get('master/dealers', [DealerController::class, 'index'])->name('master.dealers.index');
    Route::post('master/dealers/datatable', [DealerController::class, 'datatable'])->name('master.dealers.datatable');
    Route::post('master/dealers/store', [DealerController::class, 'store'])->name('master.dealers.store');
    Route::post('master/dealers/{dealer}/edit', [DealerController::class, 'edit'])->name('master.dealers.edit');
    Route::delete('master/dealers/{dealer}/destroy', [DealerController::class, 'destroy'])->name('master.dealers.destroy');

    Route::get('master/leasings', [LeasingController::class, 'index'])->name('master.leasings.index');
    Route::post('master/leasings/datatable', [LeasingController::class, 'datatable'])->name('master.leasings.datatable');
    Route::post('master/leasings/store', [LeasingController::class, 'store'])->name('master.leasings.store');
    Route::post('master/leasings/{leasing}/edit', [LeasingController::class, 'edit'])->name('master.leasings.edit');
    Route::delete('master/leasings/{leasing}/destroy', [LeasingController::class, 'destroy'])->name('master.leasings.destroy');

    Route::get('master/units', [UnitController::class, 'index'])->name('master.units.index');
    Route::post('master/units/datatable', [UnitController::class, 'datatable'])->name('master.units.datatable');
    Route::post('master/units/store', [UnitController::class, 'store'])->name('master.units.store');
    Route::post('master/units/{unit}/edit', [UnitController::class, 'edit'])->name('master.units.edit');
    Route::delete('master/units/{unit}/destroy', [UnitController::class, 'destroy'])->name('master.units.destroy');

    Route::get('asset-masters', [AssetMasterController::class, 'index'])->name('asset-masters.index');
    Route::post('asset-masters/datatable', [AssetMasterController::class, 'datatable'])->name('asset-masters.datatable');
    Route::post('asset-masters/store', [AssetMasterController::class, 'store'])->name('asset-masters.store');
    Route::post('asset-masters/{asset}/edit', [AssetMasterController::class, 'edit'])->name('asset-masters.edit');
    Route::delete('asset-masters/{asset}/destroy', [AssetMasterController::class, 'destroy'])->name('asset-masters.destroy');
});