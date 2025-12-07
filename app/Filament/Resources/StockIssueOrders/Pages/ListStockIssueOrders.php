<?php

namespace App\Filament\Resources\StockIssueOrders\Pages;

use App\Filament\Resources\StockIssueOrders\StockIssueOrderResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListStockIssueOrders extends ListRecords
{
    protected static string $resource = StockIssueOrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
