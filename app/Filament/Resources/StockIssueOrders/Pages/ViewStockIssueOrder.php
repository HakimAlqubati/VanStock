<?php

namespace App\Filament\Resources\StockIssueOrders\Pages;

use App\Filament\Resources\StockIssueOrders\StockIssueOrderResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewStockIssueOrder extends ViewRecord
{
    protected static string $resource = StockIssueOrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
