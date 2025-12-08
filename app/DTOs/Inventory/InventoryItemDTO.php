<?php

namespace App\DTOs\Inventory;

/**
 * Data Transfer Object for a single inventory item in the report
 */
class InventoryItemDTO
{
    public function __construct(
        public readonly int $productId,
        public readonly string $productName,
        public readonly int $storeId,
        public readonly string $storeName,
        public readonly int $unitId,
        public readonly string $unitName,
        public readonly float $quantityIn,
        public readonly float $quantityOut,
        public readonly float $balance,
        public readonly float $packageSize = 1,
        public readonly ?float $lastPrice = null,
        public readonly ?float $totalValue = null,
        public readonly ?string $categoryName = null,
        public readonly ?int $categoryId = null,
    ) {}

    /**
     * Create DTO from array
     */
    public static function fromArray(array $data): self
    {
        $quantityIn = (float) ($data['quantity_in'] ?? 0);
        $quantityOut = (float) ($data['quantity_out'] ?? 0);
        $balance = $quantityIn - $quantityOut;
        $lastPrice = isset($data['last_price']) ? (float) $data['last_price'] : null;

        return new self(
            productId: (int) $data['product_id'],
            productName: $data['product_name'] ?? '',
            storeId: (int) $data['store_id'],
            storeName: $data['store_name'] ?? '',
            unitId: (int) $data['unit_id'],
            unitName: $data['unit_name'] ?? '',
            quantityIn: $quantityIn,
            quantityOut: $quantityOut,
            balance: $balance,
            packageSize: (float) ($data['package_size'] ?? 1),
            lastPrice: $lastPrice,
            totalValue: $lastPrice !== null ? $balance * $lastPrice : null,
            categoryName: $data['category_name'] ?? null,
            categoryId: isset($data['category_id']) ? (int) $data['category_id'] : null,
        );
    }

    /**
     * Convert DTO to array
     */
    public function toArray(): array
    {
        return [
            'product_id' => $this->productId,
            'product_name' => $this->productName,
            'store_id' => $this->storeId,
            'store_name' => $this->storeName,
            'unit_id' => $this->unitId,
            'unit_name' => $this->unitName,
            'quantity_in' => $this->quantityIn,
            'quantity_out' => $this->quantityOut,
            'balance' => $this->balance,
            'package_size' => $this->packageSize,
            'last_price' => $this->lastPrice,
            'total_value' => $this->totalValue,
            'category_name' => $this->categoryName,
            'category_id' => $this->categoryId,
        ];
    }

    /**
     * Get balance in base units (balance * package_size)
     */
    public function getBalanceInBaseUnits(): float
    {
        return $this->balance * $this->packageSize;
    }

    /**
     * Check if item has positive balance
     */
    public function hasStock(): bool
    {
        return $this->balance > 0;
    }

    /**
     * Check if item is out of stock
     */
    public function isOutOfStock(): bool
    {
        return $this->balance <= 0;
    }
}
