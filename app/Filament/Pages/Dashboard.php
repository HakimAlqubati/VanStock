<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\CategoriesChart;
use App\Filament\Widgets\OrdersChart;
use App\Filament\Widgets\ProductsChart;
use App\Filament\Widgets\SalesMonthChart;
use App\Filament\Widgets\SalesRepresentativesChart;
use App\Filament\Widgets\Top5ProductsSalesChart;
use Filament\Facades\Filament;
use Illuminate\Contracts\Support\Htmlable;

class Dashboard extends \Filament\Pages\Dashboard
{
    public function getTitle(): string | Htmlable
    {
        return '';
    }
    public function getColumns(): int|array
    {
        return 2;
    }
    public function getWidgets(): array
    {
        return [
            SalesMonthChart::class,
            SalesRepresentativesChart::class,
            CategoriesChart::class,
            Top5ProductsSalesChart::class,
            OrdersChart::class,
            ProductsChart::class,
        ];
    }
}
