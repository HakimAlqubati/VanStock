<?php

namespace App\Observers;

use App\Models\InventoryTransaction;
use App\Models\StockSupplyOrder;
use Illuminate\Support\Facades\Log;

class StockSupplyOrderObserver
{
    /**
     * Handle the StockSupplyOrder "created" event.
     * Note: Items are saved AFTER the order in Filament, so we can't process here.
     */
    public function created(StockSupplyOrder $stockSupplyOrder): void
    {
        // Items are not yet saved at this point when using Filament Repeater
        // We will handle this in the Filament CreateRecord page instead
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
                // Check if transactions already exist for this order
                $existingTransactions = InventoryTransaction::where('transactionable_type', StockSupplyOrder::class)
                    ->where('transactionable_id', $stockSupplyOrder->id)
                    ->exists();

                if (!$existingTransactions) {
                    $this->createInventoryTransactions($stockSupplyOrder);
                }
            }
        }
    }

    /**
     * Create inventory transactions for all items in the supply order.
     */
    public function createInventoryTransactions(StockSupplyOrder $stockSupplyOrder): void
    {
        // Reload items fresh from database
        $stockSupplyOrder->load('items');

        if ($stockSupplyOrder->items->isEmpty()) {
            Log::warning("StockSupplyOrder #{$stockSupplyOrder->id} has no items to create transactions for.");
            return;
        }

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

        Log::info("Created inventory transactions for StockSupplyOrder #{$stockSupplyOrder->id}");
    }
}
