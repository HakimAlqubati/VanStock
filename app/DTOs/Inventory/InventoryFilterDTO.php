<?php

namespace App\DTOs\Inventory;

use Illuminate\Http\Request;

/**
 * Data Transfer Object for Inventory Report Filters
 * 
 * Extensible filter class that supports:
 * - Product filtering
 * - Store filtering
 * - Date range filtering
 * - Custom additional filters
 */
class InventoryFilterDTO
{
    public function __construct(
        public readonly ?int $productId = null,
        public readonly ?int $storeId = null,
        public readonly ?int $unitId = null,
        public readonly ?int $categoryId = null,
        public readonly ?string $dateFrom = null,
        public readonly ?string $dateTo = null,
        public readonly ?string $movementType = null,
        public readonly array $additionalFilters = [],
    ) {}

    /**
     * Create DTO from HTTP Request
     */
    public static function fromRequest(Request $request): self
    {
        return new self(
            productId: $request->filled('product_id') ? (int) $request->product_id : null,
            storeId: $request->filled('store_id') ? (int) $request->store_id : null,
            unitId: $request->filled('unit_id') ? (int) $request->unit_id : null,
            categoryId: $request->filled('category_id') ? (int) $request->category_id : null,
            dateFrom: $request->date_from,
            dateTo: $request->date_to,
            movementType: $request->movement_type,
            additionalFilters: $request->input('filters', []),
        );
    }

    /**
     * Create DTO from array
     */
    public static function fromArray(array $data): self
    {
        return new self(
            productId: $data['product_id'] ?? null,
            storeId: $data['store_id'] ?? null,
            unitId: $data['unit_id'] ?? null,
            categoryId: $data['category_id'] ?? null,
            dateFrom: $data['date_from'] ?? null,
            dateTo: $data['date_to'] ?? null,
            movementType: $data['movement_type'] ?? null,
            additionalFilters: $data['filters'] ?? [],
        );
    }

    /**
     * Convert DTO to array
     */
    public function toArray(): array
    {
        return array_filter([
            'product_id' => $this->productId,
            'store_id' => $this->storeId,
            'unit_id' => $this->unitId,
            'category_id' => $this->categoryId,
            'date_from' => $this->dateFrom,
            'date_to' => $this->dateTo,
            'movement_type' => $this->movementType,
            'filters' => $this->additionalFilters,
        ], fn($value) => $value !== null && $value !== []);
    }

    /**
     * Check if any filter is set
     */
    public function hasFilters(): bool
    {
        return $this->productId !== null
            || $this->storeId !== null
            || $this->unitId !== null
            || $this->categoryId !== null
            || $this->dateFrom !== null
            || $this->dateTo !== null
            || $this->movementType !== null
            || !empty($this->additionalFilters);
    }

    /**
     * Get additional filter value by key
     */
    public function getAdditionalFilter(string $key, mixed $default = null): mixed
    {
        return $this->additionalFilters[$key] ?? $default;
    }
}
