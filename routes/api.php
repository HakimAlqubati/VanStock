<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\Inventory\InventoryReportController;
use App\Http\Controllers\Api\SalesOrderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Authentication API Routes - مسارات المصادقة
|--------------------------------------------------------------------------
*/

Route::prefix('auth')->group(function () {
    // Public routes - المسارات العامة
    Route::post('/login', [AuthController::class, 'login']);

    // Protected routes - المسارات المحمية
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/me', [AuthController::class, 'me']);
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::post('/logout-all', [AuthController::class, 'logoutAll']);
        Route::post('/update-location', [AuthController::class, 'updateLocation']);
    });
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

/*
|--------------------------------------------------------------------------
| Sales Orders API Routes - مسارات أوامر البيع
|--------------------------------------------------------------------------
*/
Route::prefix('sales-orders')->middleware('auth:sanctum')->group(function () {
    Route::get('/', [SalesOrderController::class, 'index']);
    Route::post('/', [SalesOrderController::class, 'store']);
    Route::get('/{id}', [SalesOrderController::class, 'show']);
    Route::get('/data/customers', [SalesOrderController::class, 'getCustomers']);
    Route::get('/data/products', [SalesOrderController::class, 'getProducts']);
});

/*
|--------------------------------------------------------------------------
| Inventory Report API Routes
|--------------------------------------------------------------------------
*/
Route::prefix('inventory')->group(function () {
    Route::get('/stock-balance', [InventoryReportController::class, 'stockBalance']);
    Route::get('/stock-by-product', [InventoryReportController::class, 'stockByProduct']);
    Route::get('/stock-by-store', [InventoryReportController::class, 'stockByStore']);
    Route::get('/stock-by-category', [InventoryReportController::class, 'stockByCategory']);
    Route::get('/transaction-history', [InventoryReportController::class, 'transactionHistory']);
    Route::get('/low-stock', [InventoryReportController::class, 'lowStock']);
});
