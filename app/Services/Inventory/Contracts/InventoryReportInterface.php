<?php

namespace App\Services\Inventory\Contracts;

use App\DTOs\Inventory\InventoryFilterDTO;
use App\DTOs\Inventory\InventoryReportDTO;

/**
 * Interface for Inventory Report Service
 * 
 * Defines the contract for generating inventory reports
 * with various filtering and grouping options.
 */
interface InventoryReportInterface
{
    /**
     * Get complete stock balance report
     * 
     * Returns inventory balance for all products across all stores,
     * or filtered by the provided criteria.
     */
    public function getStockBalance(?InventoryFilterDTO $filters = null): InventoryReportDTO;

    /**
     * Get stock report grouped by product
     * 
     * Returns inventory summary where each row represents
     * a unique product with its total balance across all stores.
     */
    public function getStockByProduct(?InventoryFilterDTO $filters = null): InventoryReportDTO;

    /**
     * Get stock report grouped by store
     * 
     * Returns inventory summary where each row represents
     * a unique store with its total product balances.
     */
    public function getStockByStore(?InventoryFilterDTO $filters = null): InventoryReportDTO;

    /**
     * Get stock report grouped by category
     * 
     * Returns inventory summary grouped by product categories.
     */
    public function getStockByCategory(?InventoryFilterDTO $filters = null): InventoryReportDTO;

    /**
     * Get detailed transaction history
     * 
     * Returns individual transaction records with filtering.
     */
    public function getTransactionHistory(?InventoryFilterDTO $filters = null): InventoryReportDTO;

    /**
     * Get low stock alert report
     * 
     * Returns products with balance below minimum threshold.
     */
    public function getLowStockItems(int $threshold = 10, ?InventoryFilterDTO $filters = null): InventoryReportDTO;
}
