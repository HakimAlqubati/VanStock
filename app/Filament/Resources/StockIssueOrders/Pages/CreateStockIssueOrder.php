<?php

namespace App\Filament\Resources\StockIssueOrders\Pages;

use App\Filament\Resources\StockIssueOrders\StockIssueOrderResource;
use Filament\Resources\Pages\CreateRecord;

class CreateStockIssueOrder extends CreateRecord
{
    protected static string $resource = StockIssueOrderResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
