<?php

namespace App\Filament\Resources\StockSupplyOrders\Pages;

use App\Filament\Resources\StockSupplyOrders\StockSupplyOrderResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListStockSupplyOrders extends ListRecords
{
    protected static string $resource = StockSupplyOrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
