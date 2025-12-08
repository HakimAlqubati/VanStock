<?php

namespace App\Filament\Resources\StockSupplyOrders\Pages;

use App\Filament\Resources\StockSupplyOrders\StockSupplyOrderResource;
use App\Models\StockSupplyOrder;
use App\Observers\StockSupplyOrderObserver;
use Filament\Resources\Pages\CreateRecord;

class CreateStockSupplyOrder extends CreateRecord
{
    protected static string $resource = StockSupplyOrderResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    /**
     * After the record and its relationships are saved,
     * create inventory transactions if status is approved/received.
     */
    protected function afterCreate(): void
    {
        $record = $this->record;

        // If created with approved or received status, create inventory transactions
        if (in_array($record->status, [StockSupplyOrder::STATUS_APPROVED, StockSupplyOrder::STATUS_RECEIVED])) {
            $observer = new StockSupplyOrderObserver();
            $observer->createInventoryTransactions($record);
        }
    }
}
