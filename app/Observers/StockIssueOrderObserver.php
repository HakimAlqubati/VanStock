<?php

namespace App\Observers;

use App\Models\InventoryTransaction;
use App\Models\StockIssueOrder;
use Illuminate\Support\Facades\Log;

class StockIssueOrderObserver
{
    /**
     * Handle the StockIssueOrder "created" event.
     * Note: Items are saved AFTER the order in Filament, so we can't process here.
     */
    public function created(StockIssueOrder $stockIssueOrder): void
    {
        // Items are not yet saved at this point when using Filament Repeater
        // We will handle this in the Filament CreateRecord page instead
    }

    /**
     * Handle the StockIssueOrder "updated" event.
     */
    public function updated(StockIssueOrder $stockIssueOrder): void
    {
        // Check if status changed to approved or issued
        if ($stockIssueOrder->wasChanged('status')) {
            $newStatus = $stockIssueOrder->status;
            $oldStatus = $stockIssueOrder->getOriginal('status');

            // If status changed to approved or issued from a different status
            if (
                in_array($newStatus, [StockIssueOrder::STATUS_APPROVED, StockIssueOrder::STATUS_ISSUED])
                && !in_array($oldStatus, [StockIssueOrder::STATUS_APPROVED, StockIssueOrder::STATUS_ISSUED])
            ) {
                // Check if transactions already exist for this order
                $existingTransactions = InventoryTransaction::where('transactionable_type', StockIssueOrder::class)
                    ->where('transactionable_id', $stockIssueOrder->id)
                    ->exists();

                if (!$existingTransactions) {
                    $this->createInventoryTransactions($stockIssueOrder);
                }
            }
        }
    }

    /**
     * Create inventory transactions for all items in the issue order.
     * Movement type is OUT (صادر) since we are issuing stock.
     */
    public function createInventoryTransactions(StockIssueOrder $stockIssueOrder): void
    {
        // Reload items fresh from database
        $stockIssueOrder->load('items');

        if ($stockIssueOrder->items->isEmpty()) {
            Log::warning("StockIssueOrder #{$stockIssueOrder->id} has no items to create transactions for.");
            return;
        }

        foreach ($stockIssueOrder->items as $item) {
            InventoryTransaction::create([
                'product_id' => $item->product_id,
                'movement_type' => InventoryTransaction::MOVEMENT_OUT, // صادر
                'quantity' => $item->quantity,
                'unit_id' => $item->unit_id,
                'package_size' => $item->package_size ?? 1,
                'store_id' => $stockIssueOrder->store_id,
                'movement_date' => $stockIssueOrder->issue_date,
                'transaction_date' => now(),
                'transactionable_id' => $stockIssueOrder->id,
                'transactionable_type' => StockIssueOrder::class,
                'notes' => __('lang.stock_issue_order') . ': ' . $stockIssueOrder->issue_number,
            ]);
        }

        Log::info("Created inventory transactions for StockIssueOrder #{$stockIssueOrder->id}");
    }
}
