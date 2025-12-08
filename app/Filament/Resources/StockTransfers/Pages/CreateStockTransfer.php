<?php

namespace App\Filament\Resources\StockTransfers\Pages;

use App\Filament\Resources\StockTransfers\StockTransferResource;
use App\Models\StockTransfer;
use App\Observers\StockTransferObserver;
use Filament\Resources\Pages\CreateRecord;

class CreateStockTransfer extends CreateRecord
{
    protected static string $resource = StockTransferResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    /**
     * After the record and its relationships are saved,
     * create inventory transactions if status is completed.
     */
    protected function afterCreate(): void
    {
        $record = $this->record;

        // If created with completed status, create inventory transactions
        if ($record->status === StockTransfer::STATUS_COMPLETED) {
            $observer = new StockTransferObserver();
            $observer->createInventoryTransactions($record);
        }
    }
}
