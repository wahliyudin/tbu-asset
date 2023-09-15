<?php

use App\Http\Controllers\API\Assets\AssetMasterController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\Cers\CerController;
use App\Http\Controllers\API\Cers\CerItemController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', [AuthController::class, 'login']);

// Route::middleware('auth:sanctum')->group(function () {
Route::get('cers/list-no-cer', [CerController::class, 'listNoCers']);
Route::get('cers/{no}/show', [CerController::class, 'show']);
Route::post('cers/{cer:no_cer}/update-status-pr', [CerController::class, 'updateStatusPr']);

Route::get('cer-items/list-ids', [CerItemController::class, 'listIds']);

Route::get('asset-masters', [AssetMasterController::class, 'index']);
// });
