<?php

use App\Http\Controllers\Approval\ApprovalCerController;
use App\Http\Controllers\Approval\ApprovalDisposeController;
use App\Http\Controllers\Approval\ApprovalTransferController;
use App\Http\Controllers\Assets\AssetMasterController;
use App\Http\Controllers\Cers\CerController;
use App\Http\Controllers\Disposes\DisposeController;
use App\Http\Controllers\GlobalController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Masters\CatalogController;
use App\Http\Controllers\Masters\CategoryController;
use App\Http\Controllers\Masters\ClusterController;
use App\Http\Controllers\Masters\DealerController;
use App\Http\Controllers\Masters\LeasingController;
use App\Http\Controllers\Masters\SubClusterController;
use App\Http\Controllers\Masters\SubClusterItemController;
use App\Http\Controllers\Masters\UnitController;
use App\Http\Controllers\Masters\UomController;
use App\Http\Controllers\Settings\AccessPermissionController;
use App\Http\Controllers\Settings\SettingApprovalController;
use App\Http\Controllers\SSO\AuthController;
use App\Http\Controllers\ThirdParty\TXIS\BudgetController;
use App\Http\Controllers\Transfers\TransferController;
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

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/home/charts', [HomeController::class, 'charts'])->name('home.charts');

    Route::get('master/categories', [CategoryController::class, 'index'])->name('masters.categories.index')->middleware('permission:category_read');
    Route::post('master/categories/datatable', [CategoryController::class, 'datatable'])->name('masters.categories.datatable')->middleware('permission:category_read');
    Route::post('master/categories/store', [CategoryController::class, 'store'])->name('masters.categories.store')->middleware('permission:category_create');
    Route::post('master/categories/{category}/edit', [CategoryController::class, 'edit'])->name('masters.categories.edit')->middleware('permission:category_update');
    Route::delete('master/categories/{category}/destroy', [CategoryController::class, 'destroy'])->name('masters.categories.destroy')->middleware('permission:category_delete');

    Route::get('master/clusters', [ClusterController::class, 'index'])->name('masters.clusters.index')->middleware('permission:cluster_read');
    Route::post('master/clusters/datatable', [ClusterController::class, 'datatable'])->name('masters.clusters.datatable')->middleware('permission:cluster_read');
    Route::post('master/clusters/store', [ClusterController::class, 'store'])->name('masters.clusters.store')->middleware('permission:cluster_create');
    Route::post('master/clusters/{cluster}/edit', [ClusterController::class, 'edit'])->name('masters.clusters.edit')->middleware('permission:cluster_update');
    Route::delete('master/clusters/{cluster}/destroy', [ClusterController::class, 'destroy'])->name('masters.clusters.destroy')->middleware('permission:cluster_delete');

    Route::get('master/sub-clusters', [SubClusterController::class, 'index'])->name('masters.sub-clusters.index')->middleware('permission:sub_cluster_read');
    Route::post('master/sub-clusters/datatable', [SubClusterController::class, 'datatable'])->name('masters.sub-clusters.datatable')->middleware('permission:sub_cluster_read');
    Route::post('master/sub-clusters/store', [SubClusterController::class, 'store'])->name('masters.sub-clusters.store')->middleware('permission:sub_cluster_create');
    Route::post('master/sub-clusters/{subCluster}/edit', [SubClusterController::class, 'edit'])->name('masters.sub-clusters.edit')->middleware('permission:sub_cluster_update');
    Route::delete('master/sub-clusters/{subCluster}/destroy', [SubClusterController::class, 'destroy'])->name('masters.sub-clusters.destroy')->middleware('permission:sub_cluster_delete');

    Route::get('master/sub-cluster-items', [SubClusterItemController::class, 'index'])->name('masters.sub-cluster-items.index')->middleware('permission:sub_cluster_item_read');
    Route::post('master/sub-cluster-items/datatable', [SubClusterItemController::class, 'datatable'])->name('masters.sub-cluster-items.datatable')->middleware('permission:sub_cluster_item_read');
    Route::post('master/sub-cluster-items/store', [SubClusterItemController::class, 'store'])->name('masters.sub-cluster-items.store')->middleware('permission:sub_cluster_item_create');
    Route::post('master/sub-cluster-items/{subClusterItem}/edit', [SubClusterItemController::class, 'edit'])->name('masters.sub-cluster-items.edit')->middleware('permission:sub_cluster_item_update');
    Route::delete('master/sub-cluster-items/{subClusterItem}/destroy', [SubClusterItemController::class, 'destroy'])->name('masters.sub-cluster-items.destroy')->middleware('permission:sub_cluster_item_delete');

    Route::get('master/catalogs', [CatalogController::class, 'index'])->name('masters.catalogs.index')->middleware('permission:catalog_read');
    Route::post('master/catalogs/datatable', [CatalogController::class, 'datatable'])->name('masters.catalogs.datatable')->middleware('permission:catalog_read');
    Route::post('master/catalogs/store', [CatalogController::class, 'store'])->name('masters.catalogs.store')->middleware('permission:catalog_create');
    Route::post('master/catalogs/{catalog}/edit', [CatalogController::class, 'edit'])->name('masters.catalogs.edit')->middleware('permission:catalog_update');
    Route::delete('master/catalogs/{catalog}/destroy', [CatalogController::class, 'destroy'])->name('masters.catalogs.destroy')->middleware('permission:catalog_delete');

    Route::get('master/dealers', [DealerController::class, 'index'])->name('masters.dealers.index')->middleware('permission:dealer_read');
    Route::post('master/dealers/datatable', [DealerController::class, 'datatable'])->name('masters.dealers.datatable')->middleware('permission:dealer_read');
    Route::post('master/dealers/store', [DealerController::class, 'store'])->name('masters.dealers.store')->middleware('permission:dealer_create');
    Route::post('master/dealers/{dealer}/edit', [DealerController::class, 'edit'])->name('masters.dealers.edit')->middleware('permission:dealer_update');
    Route::delete('master/dealers/{dealer}/destroy', [DealerController::class, 'destroy'])->name('masters.dealers.destroy')->middleware('permission:dealer_delete');

    Route::get('master/leasings', [LeasingController::class, 'index'])->name('masters.leasings.index')->middleware('permission:leasing_read');
    Route::post('master/leasings/datatable', [LeasingController::class, 'datatable'])->name('masters.leasings.datatable')->middleware('permission:leasing_read');
    Route::post('master/leasings/store', [LeasingController::class, 'store'])->name('masters.leasings.store')->middleware('permission:leasing_create');
    Route::post('master/leasings/{leasing}/edit', [LeasingController::class, 'edit'])->name('masters.leasings.edit')->middleware('permission:leasing_update');
    Route::delete('master/leasings/{leasing}/destroy', [LeasingController::class, 'destroy'])->name('masters.leasings.destroy')->middleware('permission:leasing_delete');

    Route::get('master/units', [UnitController::class, 'index'])->name('masters.units.index')->middleware('permission:unit_read');
    Route::post('master/units/datatable', [UnitController::class, 'datatable'])->name('masters.units.datatable')->middleware('permission:unit_read');
    Route::post('master/units/store', [UnitController::class, 'store'])->name('masters.units.store')->middleware('permission:unit_create');
    Route::post('master/units/{unit}/edit', [UnitController::class, 'edit'])->name('masters.units.edit')->middleware('permission:unit_update');
    Route::delete('master/units/{unit}/destroy', [UnitController::class, 'destroy'])->name('masters.units.destroy')->middleware('permission:unit_delete');

    Route::get('master/uoms', [UomController::class, 'index'])->name('masters.uoms.index')->middleware('permission:uom_read');
    Route::post('master/uoms/datatable', [UomController::class, 'datatable'])->name('masters.uoms.datatable')->middleware('permission:uom_read');
    Route::post('master/uoms/store', [UomController::class, 'store'])->name('masters.uoms.store')->middleware('permission:uom_create');
    Route::post('master/uoms/{uom}/edit', [UomController::class, 'edit'])->name('masters.uoms.edit')->middleware('permission:uom_update');
    Route::delete('master/uoms/{uom}/destroy', [UomController::class, 'destroy'])->name('masters.uoms.destroy')->middleware('permission:uom_delete');

    Route::get('asset-masters', [AssetMasterController::class, 'index'])->name('asset-masters.index')->middleware('permission:asset_master_read');
    Route::post('asset-masters/datatable', [AssetMasterController::class, 'datatable'])->name('asset-masters.datatable')->middleware('permission:asset_master_read');
    Route::post('asset-masters/store', [AssetMasterController::class, 'store'])->name('asset-masters.store')->middleware('permission:asset_master_create|asset_master_update');
    Route::post('asset-masters/{asset}/edit', [AssetMasterController::class, 'edit'])->name('asset-masters.edit')->middleware('permission:asset_master_update');
    Route::delete('asset-masters/{asset}/destroy', [AssetMasterController::class, 'destroy'])->name('asset-masters.destroy')->middleware('permission:asset_master_delete');

    Route::get('asset-requests', [CerController::class, 'index'])->name('asset-requests.index')->middleware('permission:asset_request_read');
    Route::post('asset-requests/datatable', [CerController::class, 'datatable'])->name('asset-requests.datatable')->middleware('permission:asset_request_read');
    Route::post('asset-requests/datatable-asset-idle', [CerController::class, 'datatableAssetIdle'])->name('asset-requests.datatable-asset-idle');
    Route::get('asset-requests/create', [CerController::class, 'create'])->name('asset-requests.create')->middleware('permission:asset_request_create');
    Route::post('asset-requests/store', [CerController::class, 'store'])->name('asset-requests.store')->middleware('permission:asset_request_create');
    Route::get('asset-requests/{cer}/show', [CerController::class, 'show'])->name('asset-requests.show')->middleware('permission:asset_request_read');
    Route::get('asset-requests/{cer}/edit', [CerController::class, 'edit'])->name('asset-requests.edit')->middleware('permission:asset_request_update');
    Route::delete('asset-requests/{cer}/destroy', [CerController::class, 'destroy'])->name('asset-requests.destroy')->middleware('permission:asset_request_delete');
    Route::get('asset-requests/{cer}/register', [CerController::class, 'register'])->name('asset-requests.register');
    Route::post('asset-requests/{cer}/register', [CerController::class, 'storeRegister'])->name('asset-requests.store-register');

    Route::get('asset-transfers', [TransferController::class, 'index'])->name('asset-transfers.index')->middleware('permission:asset_transfer_read');
    Route::post('asset-transfers/datatable', [TransferController::class, 'datatable'])->name('asset-transfers.datatable')->middleware('permission:asset_transfer_read');
    Route::post('asset-transfers/datatable-asset', [TransferController::class, 'datatableAsset'])->name('asset-transfers.datatable-asset');
    Route::get('asset-transfers/create', [TransferController::class, 'create'])->name('asset-transfers.create')->middleware('permission:asset_transfer_create');
    Route::post('asset-transfers/store', [TransferController::class, 'store'])->name('asset-transfers.store')->middleware('permission:asset_transfer_create');
    Route::get('asset-transfers/{assetTransfer}/show', [TransferController::class, 'show'])->name('asset-transfers.show')->middleware('permission:asset_transfer_read');
    Route::get('asset-transfers/{assetTransfer}/edit', [TransferController::class, 'edit'])->name('asset-transfers.edit')->middleware('permission:asset_transfer_update');
    Route::delete('asset-transfers/{assetTransfer}/destroy', [TransferController::class, 'destroy'])->name('asset-transfers.destroy')->middleware('permission:asset_transfer_delete');
    Route::get('asset-transfers/{asset}/employee', [TransferController::class, 'employeeByAsset'])->name('asset-transfers.employee-by-asset');

    Route::get('asset-disposes', [DisposeController::class, 'index'])->name('asset-disposes.index')->middleware('permission:asset_dispose_read');
    Route::post('asset-disposes/datatable', [DisposeController::class, 'datatable'])->name('asset-disposes.datatable')->middleware('permission:asset_dispose_read');
    Route::post('asset-disposes/datatable-asset', [DisposeController::class, 'datatableAsset'])->name('asset-disposes.datatable-asset');
    Route::get('asset-disposes/create', [DisposeController::class, 'create'])->name('asset-disposes.create')->middleware('permission:asset_dispose_create');
    Route::post('asset-disposes/store', [DisposeController::class, 'store'])->name('asset-disposes.store')->middleware('permission:asset_dispose_create');
    Route::get('asset-disposes/{assetDispose}/show', [DisposeController::class, 'show'])->name('asset-disposes.show')->middleware('permission:asset_dispose_read');
    Route::get('asset-disposes/{assetDispose}/edit', [DisposeController::class, 'edit'])->name('asset-disposes.edit')->middleware('permission:asset_dispose_update');
    Route::delete('asset-disposes/{assetDispose}/destroy', [DisposeController::class, 'destroy'])->name('asset-disposes.destroy')->middleware('permission:asset_dispose_delete');

    Route::get('approvals/cers', [ApprovalCerController::class, 'index'])->name('approvals.cers.index')->middleware('permission:asset_request_approv|asset_request_reject');
    Route::post('approvals/cers/datatable', [ApprovalCerController::class, 'datatable'])->name('approvals.cers.datatable')->middleware('permission:asset_request_approv|asset_request_reject');
    Route::get('approvals/cers/{cer}/show', [ApprovalCerController::class, 'show'])->name('approvals.cers.show')->middleware('permission:asset_request_approv|asset_request_reject');
    Route::post('approvals/cers/{cer}/approv', [ApprovalCerController::class, 'approv'])->name('approvals.cers.approv')->middleware('permission:asset_request_approv|asset_request_reject');
    Route::post('approvals/cers/{cer}/reject', [ApprovalCerController::class, 'reject'])->name('approvals.cers.reject')->middleware('permission:asset_request_approv|asset_request_reject');

    Route::get('approvals/transfers', [ApprovalTransferController::class, 'index'])->name('approvals.transfers.index')->middleware('permission:asset_transfer_approv|asset_transfer_reject');
    Route::post('approvals/transfers/datatable', [ApprovalTransferController::class, 'datatable'])->name('approvals.transfers.datatable')->middleware('permission:asset_transfer_approv|asset_transfer_reject');
    Route::get('approvals/transfers/{assetTransfer}/show', [ApprovalTransferController::class, 'show'])->name('approvals.transfers.show')->middleware('permission:asset_transfer_approv|asset_transfer_reject');
    Route::post('approvals/transfers/{assetTransfer}/approv', [ApprovalTransferController::class, 'approv'])->name('approvals.transfers.approv')->middleware('permission:asset_transfer_approv|asset_transfer_reject');
    Route::post('approvals/transfers/{assetTransfer}/reject', [ApprovalTransferController::class, 'reject'])->name('approvals.transfers.reject')->middleware('permission:asset_transfer_approv|asset_transfer_reject');

    Route::get('approvals/disposes', [ApprovalDisposeController::class, 'index'])->name('approvals.disposes.index')->middleware('permission:asset_dispose_approv|asset_dispose_reject');
    Route::post('approvals/disposes/datatable', [ApprovalDisposeController::class, 'datatable'])->name('approvals.disposes.datatable')->middleware('permission:asset_dispose_approv|asset_dispose_reject');
    Route::get('approvals/disposes/{assetDispose}/show', [ApprovalDisposeController::class, 'show'])->name('approvals.disposes.show')->middleware('permission:asset_dispose_approv|asset_dispose_reject');
    Route::post('approvals/disposes/{assetDispose}/approv', [ApprovalDisposeController::class, 'approv'])->name('approvals.disposes.approv')->middleware('permission:asset_dispose_approv|asset_dispose_reject');
    Route::post('approvals/disposes/{assetDispose}/reject', [ApprovalDisposeController::class, 'reject'])->name('approvals.disposes.reject')->middleware('permission:asset_dispose_approv|asset_dispose_reject');

    Route::get('settings/approval', [SettingApprovalController::class, 'index'])->name('settings.approval.index')->middleware('permission:approval_read');
    Route::post('settings/approval/store', [SettingApprovalController::class, 'store'])->name('settings.approval.store')->middleware('permission:approval_update');

    Route::get('settings/access-permission', [AccessPermissionController::class, 'index'])->name('settings.access-permission.index');
    Route::post('settings/access-permission/datatable', [AccessPermissionController::class, 'datatable'])->name('settings.access-permission.datatable');
    Route::get('settings/access-permission/{user:nik}/edit', [AccessPermissionController::class, 'edit'])->name('settings.access-permission.edit');
    Route::put('settings/access-permission/{user}/update', [AccessPermissionController::class, 'update'])->name('settings.access-permission.update');

    Route::post('budgets/datatable', [BudgetController::class, 'datatable'])->name('budgets.datatable');

    Route::get('global/total-approvals', [GlobalController::class, 'totalApprovals'])->name('global.total-approvals');
});
