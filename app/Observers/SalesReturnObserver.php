<?php

namespace App\Observers;

use App\Models\InventoryTransaction;
use App\Models\SalesReturn;
use Illuminate\Support\Facades\Log;

class SalesReturnObserver
{
    /**
     * Handle the SalesReturn "created" event.
     * Note: Items are saved AFTER the return in Filament, so we can't process here.
     */
    public function created(SalesReturn $salesReturn): void
    {
        // Items are not yet saved at this point when using Filament Repeater
        // We will handle this in the Filament CreateRecord page instead
    }

    /**
     * Handle the SalesReturn "updated" event.
     */
    public function updated(SalesReturn $salesReturn): void
    {
        // Check if status changed to approved
        if ($salesReturn->wasChanged('status')) {
            $newStatus = $salesReturn->status;
            $oldStatus = $salesReturn->getOriginal('status');

            // If status changed to approved from a different status
            if ($newStatus === 'approved' && $oldStatus !== 'approved') {
                // Check if transactions already exist for this return
                $existingTransactions = InventoryTransaction::where('transactionable_type', SalesReturn::class)
                    ->where('transactionable_id', $salesReturn->id)
                    ->exists();

                if (!$existingTransactions) {
                    $this->createInventoryTransactions($salesReturn);
                }
            }
        }
    }

    /**
     * Create inventory transactions for all items in the return.
     * Movement type is IN (وارد) since items are being returned to inventory.
     */
    public function createInventoryTransactions(SalesReturn $salesReturn): void
    {
        // Reload items fresh from database
        $salesReturn->load('items');

        if ($salesReturn->items->isEmpty()) {
            Log::warning("SalesReturn #{$salesReturn->id} has no items to create transactions for.");
            return;
        }

        foreach ($salesReturn->items as $item) {
            InventoryTransaction::create([
                'product_id' => $item->product_id,
                'movement_type' => InventoryTransaction::MOVEMENT_IN,
                'quantity' => $item->quantity,
                'unit_id' => $item->unit_id,
                'package_size' => $item->package_size ?? 1,
                'store_id' => $salesReturn->store_id,
                'movement_date' => $salesReturn->return_date,
                'transaction_date' => now(),
                'transactionable_id' => $salesReturn->id,
                'transactionable_type' => SalesReturn::class,
                'price' => $item->unit_price,
                'notes' => __('lang.sales_return') . ': ' . $salesReturn->return_number,
            ]);
        }

        Log::info("Created inventory transactions for SalesReturn #{$salesReturn->id}");
    }
}
