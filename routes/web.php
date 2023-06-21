<?php

use App\Http\Controllers\Assets\AssetMasterController;
use App\Http\Controllers\Cers\CerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Masters\CatalogController;
use App\Http\Controllers\Masters\CategoryController;
use App\Http\Controllers\Masters\ClusterController;
use App\Http\Controllers\Masters\DealerController;
use App\Http\Controllers\Masters\LeasingController;
use App\Http\Controllers\Masters\SubClusterController;
use App\Http\Controllers\Masters\SubClusterItemController;
use App\Http\Controllers\Masters\UnitController;
use App\Http\Controllers\Settings\SettingApprovalController;
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

    Route::get('master/categories', [CategoryController::class, 'index'])->name('masters.categories.index');
    Route::post('master/categories/datatable', [CategoryController::class, 'datatable'])->name('masters.categories.datatable');
    Route::post('master/categories/store', [CategoryController::class, 'store'])->name('masters.categories.store');
    Route::post('master/categories/{category}/edit', [CategoryController::class, 'edit'])->name('masters.categories.edit');
    Route::delete('master/categories/{category}/destroy', [CategoryController::class, 'destroy'])->name('masters.categories.destroy');

    Route::get('master/clusters', [ClusterController::class, 'index'])->name('masters.clusters.index');
    Route::post('master/clusters/datatable', [ClusterController::class, 'datatable'])->name('masters.clusters.datatable');
    Route::post('master/clusters/store', [ClusterController::class, 'store'])->name('masters.clusters.store');
    Route::post('master/clusters/{cluster}/edit', [ClusterController::class, 'edit'])->name('masters.clusters.edit');
    Route::delete('master/clusters/{cluster}/destroy', [ClusterController::class, 'destroy'])->name('masters.clusters.destroy');

    Route::get('master/sub-clusters', [SubClusterController::class, 'index'])->name('masters.sub-clusters.index');
    Route::post('master/sub-clusters/datatable', [SubClusterController::class, 'datatable'])->name('masters.sub-clusters.datatable');
    Route::post('master/sub-clusters/store', [SubClusterController::class, 'store'])->name('masters.sub-clusters.store');
    Route::post('master/sub-clusters/{subCluster}/edit', [SubClusterController::class, 'edit'])->name('masters.sub-clusters.edit');
    Route::delete('master/sub-clusters/{subCluster}/destroy', [SubClusterController::class, 'destroy'])->name('masters.sub-clusters.destroy');

    Route::get('master/sub-cluster-items', [SubClusterItemController::class, 'index'])->name('masters.sub-cluster-items.index');
    Route::post('master/sub-cluster-items/datatable', [SubClusterItemController::class, 'datatable'])->name('masters.sub-cluster-items.datatable');
    Route::post('master/sub-cluster-items/store', [SubClusterItemController::class, 'store'])->name('masters.sub-cluster-items.store');
    Route::post('master/sub-cluster-items/{subClusterItem}/edit', [SubClusterItemController::class, 'edit'])->name('masters.sub-cluster-items.edit');
    Route::delete('master/sub-cluster-items/{subClusterItem}/destroy', [SubClusterItemController::class, 'destroy'])->name('masters.sub-cluster-items.destroy');

    Route::get('master/catalogs', [CatalogController::class, 'index'])->name('masters.catalogs.index');
    Route::post('master/catalogs/datatable', [CatalogController::class, 'datatable'])->name('masters.catalogs.datatable');
    Route::post('master/catalogs/store', [CatalogController::class, 'store'])->name('masters.catalogs.store');
    Route::post('master/catalogs/{catalog}/edit', [CatalogController::class, 'edit'])->name('masters.catalogs.edit');
    Route::delete('master/catalogs/{catalog}/destroy', [CatalogController::class, 'destroy'])->name('masters.catalogs.destroy');

    Route::get('master/dealers', [DealerController::class, 'index'])->name('masters.dealers.index');
    Route::post('master/dealers/datatable', [DealerController::class, 'datatable'])->name('masters.dealers.datatable');
    Route::post('master/dealers/store', [DealerController::class, 'store'])->name('masters.dealers.store');
    Route::post('master/dealers/{dealer}/edit', [DealerController::class, 'edit'])->name('masters.dealers.edit');
    Route::delete('master/dealers/{dealer}/destroy', [DealerController::class, 'destroy'])->name('masters.dealers.destroy');

    Route::get('master/leasings', [LeasingController::class, 'index'])->name('masters.leasings.index');
    Route::post('master/leasings/datatable', [LeasingController::class, 'datatable'])->name('masters.leasings.datatable');
    Route::post('master/leasings/store', [LeasingController::class, 'store'])->name('masters.leasings.store');
    Route::post('master/leasings/{leasing}/edit', [LeasingController::class, 'edit'])->name('masters.leasings.edit');
    Route::delete('master/leasings/{leasing}/destroy', [LeasingController::class, 'destroy'])->name('masters.leasings.destroy');

    Route::get('master/units', [UnitController::class, 'index'])->name('masters.units.index');
    Route::post('master/units/datatable', [UnitController::class, 'datatable'])->name('masters.units.datatable');
    Route::post('master/units/store', [UnitController::class, 'store'])->name('masters.units.store');
    Route::post('master/units/{unit}/edit', [UnitController::class, 'edit'])->name('masters.units.edit');
    Route::delete('master/units/{unit}/destroy', [UnitController::class, 'destroy'])->name('masters.units.destroy');

    Route::get('asset-masters', [AssetMasterController::class, 'index'])->name('asset-masters.index');
    Route::post('asset-masters/datatable', [AssetMasterController::class, 'datatable'])->name('asset-masters.datatable');
    Route::post('asset-masters/store', [AssetMasterController::class, 'store'])->name('asset-masters.store');
    Route::post('asset-masters/{asset}/edit', [AssetMasterController::class, 'edit'])->name('asset-masters.edit');
    Route::delete('asset-masters/{asset}/destroy', [AssetMasterController::class, 'destroy'])->name('asset-masters.destroy');

    Route::get('asset-requests', [CerController::class, 'index'])->name('asset-requests.index');
    Route::post('asset-requests/datatable', [CerController::class, 'datatable'])->name('asset-requests.datatable');
    Route::get('asset-requests/create', [CerController::class, 'create'])->name('asset-requests.create');
    Route::post('asset-requests/store', [CerController::class, 'store'])->name('asset-requests.store');
    Route::post('asset-requests/{cer}/edit', [CerController::class, 'edit'])->name('asset-requests.edit');
    Route::delete('asset-requests/{cer}/destroy', [CerController::class, 'destroy'])->name('asset-requests.destroy');

    Route::get('settings/approval', [SettingApprovalController::class, 'index'])->name('settings.approval.index');
    Route::post('settings/approval/store', [SettingApprovalController::class, 'store'])->name('settings.approval.store');
});
