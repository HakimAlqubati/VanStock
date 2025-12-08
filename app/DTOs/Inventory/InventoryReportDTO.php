<?php

namespace App\DTOs\Inventory;

use Illuminate\Support\Collection;

/**
 * Data Transfer Object for the complete inventory report
 */
class InventoryReportDTO
{
    /** @var Collection<int, InventoryItemDTO> */
    public readonly Collection $items;

    /**
     * @param Collection<int, InventoryItemDTO>|array $items
     */
    public function __construct(
        Collection|array $items,
        public readonly float $totalQuantityIn = 0,
        public readonly float $totalQuantityOut = 0,
        public readonly float $totalBalance = 0,
        public readonly ?float $totalValue = null,
        public readonly ?InventoryFilterDTO $appliedFilters = null,
        public readonly ?string $generatedAt = null,
    ) {
        $this->items = $items instanceof Collection ? $items : collect($items);
    }

    /**
     * Create report from items collection with auto-calculated totals
     * 
     * @param Collection<int, InventoryItemDTO>|array $items
     */
    public static function fromItems(
        Collection|array $items,
        ?InventoryFilterDTO $filters = null
    ): self {
        $collection = $items instanceof Collection ? $items : collect($items);

        $totalIn = $collection->sum('quantityIn');
        $totalOut = $collection->sum('quantityOut');
        $totalBalance = $collection->sum('balance');
        $totalValue = $collection->sum('totalValue');

        return new self(
            items: $collection,
            totalQuantityIn: $totalIn,
            totalQuantityOut: $totalOut,
            totalBalance: $totalBalance,
            totalValue: $totalValue,
            appliedFilters: $filters,
            generatedAt: now()->toIso8601String(),
        );
    }

    /**
     * Convert report to array
     */
    public function toArray(): array
    {
        return [
            'items' => $this->items->map(fn(InventoryItemDTO $item) => $item->toArray())->values()->all(),
            'summary' => [
                'total_quantity_in' => $this->totalQuantityIn,
                'total_quantity_out' => $this->totalQuantityOut,
                'total_balance' => $this->totalBalance,
                'total_value' => $this->totalValue,
                'items_count' => $this->items->count(),
            ],
            'filters' => $this->appliedFilters?->toArray() ?? [],
            'generated_at' => $this->generatedAt,
        ];
    }

    /**
     * Get items with positive balance only
     */
    public function getInStockItems(): Collection
    {
        return $this->items->filter(fn(InventoryItemDTO $item) => $item->hasStock());
    }

    /**
     * Get items with zero or negative balance
     */
    public function getOutOfStockItems(): Collection
    {
        return $this->items->filter(fn(InventoryItemDTO $item) => $item->isOutOfStock());
    }

    /**
     * Get items grouped by store
     */
    public function groupByStore(): Collection
    {
        return $this->items->groupBy('storeId');
    }

    /**
     * Get items grouped by product
     */
    public function groupByProduct(): Collection
    {
        return $this->items->groupBy('productId');
    }

    /**
     * Get items grouped by category
     */
    public function groupByCategory(): Collection
    {
        return $this->items->groupBy('categoryId');
    }

    /**
     * Check if report is empty
     */
    public function isEmpty(): bool
    {
        return $this->items->isEmpty();
    }

    /**
     * Get items count
     */
    public function count(): int
    {
        return $this->items->count();
    }
}
