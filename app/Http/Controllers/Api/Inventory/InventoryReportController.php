<?php

namespace App\Http\Controllers\Api\Inventory;

use App\DTOs\Inventory\InventoryFilterDTO;
use App\Http\Controllers\Controller;
use App\Services\Inventory\InventoryReportService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Inventory Report API Controller
 * 
 * Provides RESTful API endpoints for inventory reporting.
 */
class InventoryReportController extends Controller
{
    public function __construct(
        protected InventoryReportService $reportService
    ) {}

    /**
     * Get stock balance report
     * 
     * @queryParam product_id int Filter by product ID
     * @queryParam store_id int Filter by store ID
     * @queryParam unit_id int Filter by unit ID
     * @queryParam category_id int Filter by category ID
     * @queryParam date_from string Filter from date (Y-m-d)
     * @queryParam date_to string Filter to date (Y-m-d)
     */
    public function stockBalance(Request $request): JsonResponse
    {
        $filters = InventoryFilterDTO::fromRequest($request);
        $report = $this->reportService->getStockBalance($filters);

        return response()->json([
            'success' => true,
            'data' => $report->toArray(),
        ]);
    }

    /**
     * Get stock report grouped by product
     */
    public function stockByProduct(Request $request): JsonResponse
    {
        $filters = InventoryFilterDTO::fromRequest($request);
        $report = $this->reportService->getStockByProduct($filters);

        return response()->json([
            'success' => true,
            'data' => $report->toArray(),
        ]);
    }

    /**
     * Get stock report grouped by store
     */
    public function stockByStore(Request $request): JsonResponse
    {
        $filters = InventoryFilterDTO::fromRequest($request);
        $report = $this->reportService->getStockByStore($filters);

        return response()->json([
            'success' => true,
            'data' => $report->toArray(),
        ]);
    }

    /**
     * Get stock report grouped by category
     */
    public function stockByCategory(Request $request): JsonResponse
    {
        $filters = InventoryFilterDTO::fromRequest($request);
        $report = $this->reportService->getStockByCategory($filters);

        return response()->json([
            'success' => true,
            'data' => $report->toArray(),
        ]);
    }

    /**
     * Get transaction history
     */
    public function transactionHistory(Request $request): JsonResponse
    {
        $filters = InventoryFilterDTO::fromRequest($request);
        $report = $this->reportService->getTransactionHistory($filters);

        return response()->json([
            'success' => true,
            'data' => $report->toArray(),
        ]);
    }

    /**
     * Get low stock items
     * 
     * @queryParam threshold int Minimum stock threshold (default: 10)
     */
    public function lowStock(Request $request): JsonResponse
    {
        $threshold = $request->input('threshold', 10);
        $filters = InventoryFilterDTO::fromRequest($request);
        $report = $this->reportService->getLowStockItems($threshold, $filters);

        return response()->json([
            'success' => true,
            'data' => $report->toArray(),
        ]);
    }
}
