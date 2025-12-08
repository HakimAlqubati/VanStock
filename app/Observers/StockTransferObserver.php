<?php

namespace App\Observers;

use App\Models\InventoryTransaction;
use App\Models\StockTransfer;
use Illuminate\Support\Facades\Log;

class StockTransferObserver
{
    /**
     * Handle the StockTransfer "created" event.
     * Note: Items are saved AFTER the order in Filament, so we can't process here.
     */
    public function created(StockTransfer $stockTransfer): void
    {
        // Items are not yet saved at this point when using Filament Repeater
        // We will handle this in the Filament CreateRecord page instead
    }

    /**
     * Handle the StockTransfer "updated" event.
     */
    public function updated(StockTransfer $stockTransfer): void
    {
        // Check if status changed to completed
        if ($stockTransfer->wasChanged('status')) {
            $newStatus = $stockTransfer->status;
            $oldStatus = $stockTransfer->getOriginal('status');
            // If status changed to completed from a different status
            if (
                $newStatus === StockTransfer::STATUS_COMPLETED
                && $oldStatus !== StockTransfer::STATUS_COMPLETED
            ) {
                // Check if transactions already exist for this transfer
                $existingTransactions = InventoryTransaction::where('transactionable_type', StockTransfer::class)
                    ->where('transactionable_id', $stockTransfer->id)
                    ->exists();

                if (!$existingTransactions) {
                    $this->createInventoryTransactions($stockTransfer);
                }
            }
        }
    }

    /**
     * Create inventory transactions for all items in the transfer.
     * Creates two transactions per item:
     * 1. OUT from source store (from_store_id)
     * 2. IN to destination store (to_store_id)
     */
    public function createInventoryTransactions(StockTransfer $stockTransfer): void
    {
        // Reload items fresh from database
        $stockTransfer->load('items');

        if ($stockTransfer->items->isEmpty()) {
            Log::warning("StockTransfer #{$stockTransfer->id} has no items to create transactions for.");
            return;
        }

        foreach ($stockTransfer->items as $item) {
            // Transaction OUT from source store (صادر من المخزن المصدر)
            InventoryTransaction::create([
                'product_id' => $item->product_id,
                'movement_type' => InventoryTransaction::MOVEMENT_OUT,
                'quantity' => $item->quantity,
                'unit_id' => $item->unit_id,
                'package_size' => $item->package_size ?? 1,
                'store_id' => $stockTransfer->from_store_id,
                'movement_date' => $stockTransfer->transfer_date,
                'transaction_date' => now(),
                'transactionable_id' => $stockTransfer->id,
                'transactionable_type' => StockTransfer::class,
                'notes' => __('lang.stock_transfer') . ' (OUT): ' . $stockTransfer->transfer_number,
            ]);

            // Transaction IN to destination store (وارد إلى المخزن الوجهة)
            InventoryTransaction::create([
                'product_id' => $item->product_id,
                'movement_type' => InventoryTransaction::MOVEMENT_IN,
                'quantity' => $item->quantity,
                'unit_id' => $item->unit_id,
                'package_size' => $item->package_size ?? 1,
                'store_id' => $stockTransfer->to_store_id,
                'movement_date' => $stockTransfer->transfer_date,
                'transaction_date' => now(),
                'transactionable_id' => $stockTransfer->id,
                'transactionable_type' => StockTransfer::class,
                'notes' => __('lang.stock_transfer') . ' (IN): ' . $stockTransfer->transfer_number,
                'remaining_quantity' => $item->quantity,
            ]);
        }

        Log::info("Created inventory transactions for StockTransfer #{$stockTransfer->id}");
    }
}
