<?php

namespace App\Observers;

use App\Models\InventoryTransaction;
use App\Models\StockSupplyOrder;

class StockSupplyOrderObserver
{
    /**
     * Handle the StockSupplyOrder "created" event.
     */
    public function created(StockSupplyOrder $stockSupplyOrder): void
    {
        // If created with approved or received status, create inventory transactions
        if (in_array($stockSupplyOrder->status, [StockSupplyOrder::STATUS_APPROVED, StockSupplyOrder::STATUS_RECEIVED])) {
            $this->createInventoryTransactions($stockSupplyOrder);
        }
    }

    /**
     * Handle the StockSupplyOrder "updated" event.
     */
    public function updated(StockSupplyOrder $stockSupplyOrder): void
    {
        // Check if status changed to approved or received
        if ($stockSupplyOrder->wasChanged('status')) {
            $newStatus = $stockSupplyOrder->status;
            $oldStatus = $stockSupplyOrder->getOriginal('status');

            // If status changed to approved or received from a different status
            if (
                in_array($newStatus, [StockSupplyOrder::STATUS_APPROVED, StockSupplyOrder::STATUS_RECEIVED])
                && !in_array($oldStatus, [StockSupplyOrder::STATUS_APPROVED, StockSupplyOrder::STATUS_RECEIVED])
            ) {
                $this->createInventoryTransactions($stockSupplyOrder);
            }
        }
    }

    /**
     * Create inventory transactions for all items in the supply order.
     */
    protected function createInventoryTransactions(StockSupplyOrder $stockSupplyOrder): void
    {
        // Load items if not loaded
        $stockSupplyOrder->loadMissing('items');

        foreach ($stockSupplyOrder->items as $item) {
            InventoryTransaction::create([
                'product_id' => $item->product_id,
                'movement_type' => InventoryTransaction::MOVEMENT_IN,
                'quantity' => $item->quantity,
                'unit_id' => $item->unit_id,
                'package_size' => $item->package_size ?? 1,
                'store_id' => $stockSupplyOrder->store_id,
                'movement_date' => $stockSupplyOrder->supply_date,
                'transaction_date' => now(),
                'price' => $item->unit_cost,
                'transactionable_id' => $stockSupplyOrder->id,
                'transactionable_type' => StockSupplyOrder::class,
                'notes' => __('lang.stock_supply_order') . ': ' . $stockSupplyOrder->supply_number,
                'remaining_quantity' => $item->quantity,
            ]);
        }
    }
}
