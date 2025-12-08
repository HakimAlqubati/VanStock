<?php

use App\Http\Controllers\Api\Inventory\InventoryReportController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

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
