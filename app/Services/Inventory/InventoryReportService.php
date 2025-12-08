<?php

namespace App\Services\Inventory;

use App\DTOs\Inventory\InventoryFilterDTO;
use App\DTOs\Inventory\InventoryItemDTO;
use App\DTOs\Inventory\InventoryReportDTO;
use App\Models\InventoryTransaction;
use App\Services\Inventory\Contracts\InventoryReportInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

/**
 * Inventory Report Service
 * 
 * Provides methods for generating various inventory reports
 * by aggregating data from the inventory_transactions table.
 */
class InventoryReportService implements InventoryReportInterface
{
    /**
     * Get complete stock balance report
     * 
     * Calculates balance in BASE UNITS by multiplying quantity * package_size.
     * This ensures proper unit conversion (e.g., 1 ton with package_size=10 = 10 base units).
     */
    public function getStockBalance(?InventoryFilterDTO $filters = null): InventoryReportDTO
    {
        $query = $this->buildBaseQuery($filters);

        // Calculate quantities in BASE UNITS (quantity * package_size)
        $results = $query
            ->select([
                'inventory_transactions.product_id',
                'products.name as product_name',
                'inventory_transactions.store_id',
                'stores.name as store_name',
                'categories.id as category_id',
                'categories.name as category_name',
                // Convert to base units: quantity * package_size
                DB::raw("SUM(CASE WHEN movement_type = 'in' THEN (quantity * COALESCE(inventory_transactions.package_size, 1)) ELSE 0 END) as base_quantity_in"),
                DB::raw("SUM(CASE WHEN movement_type = 'out' THEN (quantity * COALESCE(inventory_transactions.package_size, 1)) ELSE 0 END) as base_quantity_out"),
            ])
            ->groupBy([
                'inventory_transactions.product_id',
                'products.name',
                'inventory_transactions.store_id',
                'stores.name',
                'categories.id',
                'categories.name',
            ])
            ->get();

        // Get the smallest unit (base unit) for each product
        $items = $results->map(function ($row) {
            // Find the base unit (smallest package_size = 1) for this product
            $baseUnit = $this->getBaseUnitForProduct($row->product_id);

            $baseIn = (float) $row->base_quantity_in;
            $baseOut = (float) $row->base_quantity_out;
            $balance = $baseIn - $baseOut;

            return InventoryItemDTO::fromArray([
                'product_id' => $row->product_id,
                'product_name' => $row->product_name,
                'store_id' => $row->store_id,
                'store_name' => $row->store_name,
                'unit_id' => $baseUnit['id'] ?? 0,
                'unit_name' => $baseUnit['name'] ?? 'وحدة',
                'quantity_in' => $baseIn,
                'quantity_out' => $baseOut,
                'package_size' => 1, // Base unit always has package_size = 1
                'category_id' => $row->category_id,
                'category_name' => $row->category_name,
            ]);
        });

        return InventoryReportDTO::fromItems($items, $filters);
    }

    /**
     * Get stock report grouped by product
     * 
     * Calculates balance in BASE UNITS (quantity * package_size).
     */
    public function getStockByProduct(?InventoryFilterDTO $filters = null): InventoryReportDTO
    {
        $query = $this->buildBaseQuery($filters);

        $results = $query
            ->select([
                'inventory_transactions.product_id',
                'products.name as product_name',
                'categories.id as category_id',
                'categories.name as category_name',
                // Convert to base units: quantity * package_size
                DB::raw("SUM(CASE WHEN movement_type = 'in' THEN (quantity * COALESCE(inventory_transactions.package_size, 1)) ELSE 0 END) as base_quantity_in"),
                DB::raw("SUM(CASE WHEN movement_type = 'out' THEN (quantity * COALESCE(inventory_transactions.package_size, 1)) ELSE 0 END) as base_quantity_out"),
            ])
            ->groupBy([
                'inventory_transactions.product_id',
                'products.name',
                'categories.id',
                'categories.name',
            ])
            ->get();

        $items = $results->map(function ($row) {
            $baseUnit = $this->getBaseUnitForProduct($row->product_id);

            return InventoryItemDTO::fromArray([
                'product_id' => $row->product_id,
                'product_name' => $row->product_name,
                'store_id' => 0,
                'store_name' => 'جميع المخازن',
                'unit_id' => $baseUnit['id'] ?? 0,
                'unit_name' => $baseUnit['name'] ?? 'وحدة',
                'quantity_in' => (float) $row->base_quantity_in,
                'quantity_out' => (float) $row->base_quantity_out,
                'package_size' => 1,
                'category_id' => $row->category_id,
                'category_name' => $row->category_name,
            ]);
        });

        return InventoryReportDTO::fromItems($items, $filters);
    }

    /**
     * Get stock report grouped by store
     * 
     * Calculates balance in BASE UNITS (quantity * package_size).
     */
    public function getStockByStore(?InventoryFilterDTO $filters = null): InventoryReportDTO
    {
        $query = $this->buildBaseQuery($filters);

        $results = $query
            ->select([
                'inventory_transactions.store_id',
                'stores.name as store_name',
                // Convert to base units: quantity * package_size
                DB::raw("SUM(CASE WHEN movement_type = 'in' THEN (quantity * COALESCE(inventory_transactions.package_size, 1)) ELSE 0 END) as base_quantity_in"),
                DB::raw("SUM(CASE WHEN movement_type = 'out' THEN (quantity * COALESCE(inventory_transactions.package_size, 1)) ELSE 0 END) as base_quantity_out"),
                DB::raw('COUNT(DISTINCT inventory_transactions.product_id) as product_count'),
            ])
            ->groupBy([
                'inventory_transactions.store_id',
                'stores.name',
            ])
            ->get();

        $items = $results->map(function ($row) {
            return InventoryItemDTO::fromArray([
                'product_id' => 0,
                'product_name' => "({$row->product_count} منتج)",
                'store_id' => $row->store_id,
                'store_name' => $row->store_name,
                'unit_id' => 0,
                'unit_name' => 'وحدة',
                'quantity_in' => (float) $row->base_quantity_in,
                'quantity_out' => (float) $row->base_quantity_out,
            ]);
        });

        return InventoryReportDTO::fromItems($items, $filters);
    }

    /**
     * Get stock report grouped by category
     * 
     * Calculates balance in BASE UNITS (quantity * package_size).
     */
    public function getStockByCategory(?InventoryFilterDTO $filters = null): InventoryReportDTO
    {
        $query = $this->buildBaseQuery($filters);

        $results = $query
            ->select([
                'categories.id as category_id',
                'categories.name as category_name',
                // Convert to base units: quantity * package_size
                DB::raw("SUM(CASE WHEN movement_type = 'in' THEN (quantity * COALESCE(inventory_transactions.package_size, 1)) ELSE 0 END) as base_quantity_in"),
                DB::raw("SUM(CASE WHEN movement_type = 'out' THEN (quantity * COALESCE(inventory_transactions.package_size, 1)) ELSE 0 END) as base_quantity_out"),
                DB::raw('COUNT(DISTINCT inventory_transactions.product_id) as product_count'),
            ])
            ->groupBy([
                'categories.id',
                'categories.name',
            ])
            ->get();

        $items = $results->map(function ($row) {
            return InventoryItemDTO::fromArray([
                'product_id' => 0,
                'product_name' => "({$row->product_count} منتج)",
                'store_id' => 0,
                'store_name' => '',
                'unit_id' => 0,
                'unit_name' => 'وحدة',
                'quantity_in' => (float) $row->base_quantity_in,
                'quantity_out' => (float) $row->base_quantity_out,
                'category_id' => $row->category_id,
                'category_name' => $row->category_name,
            ]);
        });

        return InventoryReportDTO::fromItems($items, $filters);
    }

    /**
     * Get detailed transaction history
     * 
     * Shows individual transactions with quantities converted to base units.
     */
    public function getTransactionHistory(?InventoryFilterDTO $filters = null): InventoryReportDTO
    {
        $query = $this->buildBaseQuery($filters);

        $results = $query
            ->select([
                'inventory_transactions.id',
                'inventory_transactions.product_id',
                'products.name as product_name',
                'inventory_transactions.store_id',
                'stores.name as store_name',
                'inventory_transactions.unit_id',
                'units.name as unit_name',
                'inventory_transactions.movement_type',
                'inventory_transactions.quantity',
                'inventory_transactions.package_size',
                'inventory_transactions.movement_date',
                'categories.id as category_id',
                'categories.name as category_name',
            ])
            ->orderBy('inventory_transactions.movement_date', 'desc')
            ->limit(1000)
            ->get();

        $items = $results->map(function ($row) {
            $packageSize = $row->package_size ?? 1;
            $baseQuantity = $row->quantity * $packageSize;

            // Calculate base unit quantities
            $quantityIn = $row->movement_type === 'in' ? $baseQuantity : 0;
            $quantityOut = $row->movement_type === 'out' ? $baseQuantity : 0;

            $baseUnit = $this->getBaseUnitForProduct($row->product_id);

            return InventoryItemDTO::fromArray([
                'product_id' => $row->product_id,
                'product_name' => $row->product_name,
                'store_id' => $row->store_id,
                'store_name' => $row->store_name,
                'unit_id' => $baseUnit['id'] ?? $row->unit_id,
                'unit_name' => $baseUnit['name'] ?? $row->unit_name,
                'quantity_in' => $quantityIn,
                'quantity_out' => $quantityOut,
                'package_size' => 1,
                'category_id' => $row->category_id,
                'category_name' => $row->category_name,
            ]);
        });

        return InventoryReportDTO::fromItems($items, $filters);
    }

    /**
     * Get low stock alert report
     */
    public function getLowStockItems(int $threshold = 10, ?InventoryFilterDTO $filters = null): InventoryReportDTO
    {
        $report = $this->getStockBalance($filters);

        $lowStockItems = $report->items->filter(function (InventoryItemDTO $item) use ($threshold) {
            return $item->balance <= $threshold;
        });

        return InventoryReportDTO::fromItems($lowStockItems, $filters);
    }

    /**
     * Build base query with joins and filters
     */
    protected function buildBaseQuery(?InventoryFilterDTO $filters): Builder
    {
        $query = InventoryTransaction::query()
            ->join('products', 'inventory_transactions.product_id', '=', 'products.id')
            ->join('stores', 'inventory_transactions.store_id', '=', 'stores.id')
            ->leftJoin('units', 'inventory_transactions.unit_id', '=', 'units.id')
            ->leftJoin('categories', 'products.category_id', '=', 'categories.id');

        if ($filters !== null) {
            $this->applyFilters($query, $filters);
        }

        return $query;
    }

    /**
     * Apply filters to query
     */
    protected function applyFilters(Builder $query, InventoryFilterDTO $filters): void
    {
        if ($filters->productId !== null) {
            $query->where('inventory_transactions.product_id', $filters->productId);
        }

        if ($filters->storeId !== null) {
            $query->where('inventory_transactions.store_id', $filters->storeId);
        }

        if ($filters->unitId !== null) {
            $query->where('inventory_transactions.unit_id', $filters->unitId);
        }

        if ($filters->categoryId !== null) {
            $query->where('products.category_id', $filters->categoryId);
        }

        if ($filters->dateFrom !== null) {
            $query->where('inventory_transactions.movement_date', '>=', $filters->dateFrom);
        }

        if ($filters->dateTo !== null) {
            $query->where('inventory_transactions.movement_date', '<=', $filters->dateTo);
        }

        if ($filters->movementType !== null) {
            $query->where('inventory_transactions.movement_type', $filters->movementType);
        }
    }

    /**
     * Map database results to InventoryItemDTO collection
     */
    protected function mapResultsToItems(Collection $results): Collection
    {
        return $results->map(function ($row) {
            return InventoryItemDTO::fromArray([
                'product_id' => $row->product_id,
                'product_name' => $row->product_name,
                'store_id' => $row->store_id,
                'store_name' => $row->store_name,
                'unit_id' => $row->unit_id,
                'unit_name' => $row->unit_name,
                'quantity_in' => $row->quantity_in,
                'quantity_out' => $row->quantity_out,
                'package_size' => $row->package_size ?? 1,
                'category_id' => $row->category_id,
                'category_name' => $row->category_name,
            ]);
        });
    }

    /**
     * Get the base unit (smallest package_size = 1) for a product
     * 
     * Returns the unit with package_size = 1 from ProductUnit,
     * or falls back to the first unit found for this product.
     */
    protected function getBaseUnitForProduct(int $productId): array
    {
        // Try to find the base unit from ProductUnit table
        $baseUnit = DB::table('product_units')
            ->join('units', 'product_units.unit_id', '=', 'units.id')
            ->where('product_units.product_id', $productId)
            ->where('product_units.package_size', 1)
            ->select('units.id', 'units.name')
            ->first();

        if ($baseUnit) {
            return ['id' => $baseUnit->id, 'name' => $baseUnit->name];
        }

        // Fallback: find the unit with smallest package_size
        $smallestUnit = DB::table('product_units')
            ->join('units', 'product_units.unit_id', '=', 'units.id')
            ->where('product_units.product_id', $productId)
            ->orderBy('product_units.package_size', 'asc')
            ->select('units.id', 'units.name')
            ->first();

        if ($smallestUnit) {
            return ['id' => $smallestUnit->id, 'name' => $smallestUnit->name];
        }

        // Final fallback: get any unit from inventory transactions
        $transactionUnit = DB::table('inventory_transactions')
            ->join('units', 'inventory_transactions.unit_id', '=', 'units.id')
            ->where('inventory_transactions.product_id', $productId)
            ->select('units.id', 'units.name')
            ->first();

        if ($transactionUnit) {
            return ['id' => $transactionUnit->id, 'name' => $transactionUnit->name];
        }

        return ['id' => 0, 'name' => 'وحدة'];
    }
}
