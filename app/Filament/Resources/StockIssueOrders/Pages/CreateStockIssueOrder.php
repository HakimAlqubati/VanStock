<?php

namespace App\Filament\Resources\StockIssueOrders\Pages;

use App\Filament\Resources\StockIssueOrders\StockIssueOrderResource;
use App\Models\StockIssueOrder;
use App\Observers\StockIssueOrderObserver;
use Filament\Resources\Pages\CreateRecord;

class CreateStockIssueOrder extends CreateRecord
{
    protected static string $resource = StockIssueOrderResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    /**
     * After the record and its relationships are saved,
     * create inventory transactions if status is approved/issued.
     */
    protected function afterCreate(): void
    {
        $record = $this->record;

        // If created with approved or issued status, create inventory transactions
        if (in_array($record->status, [StockIssueOrder::STATUS_APPROVED, StockIssueOrder::STATUS_ISSUED])) {
            $observer = new StockIssueOrderObserver();
            $observer->createInventoryTransactions($record);
        }
    }
}
