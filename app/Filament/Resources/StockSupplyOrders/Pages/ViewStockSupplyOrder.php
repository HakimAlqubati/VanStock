<?php

namespace App\Filament\Resources\StockSupplyOrders\Pages;

use App\Filament\Resources\StockSupplyOrders\StockSupplyOrderResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewStockSupplyOrder extends ViewRecord
{
    protected static string $resource = StockSupplyOrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
