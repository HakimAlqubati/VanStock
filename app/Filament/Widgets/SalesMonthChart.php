<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Illuminate\Contracts\Support\Htmlable;

class SalesMonthChart extends ChartWidget
{
    protected ?string $heading = 'Sales per Month';

    public function getHeading(): string | Htmlable | null
    {
        return __('lang.sales_per_month');
    }

    protected static ?int $sort = 6;
    protected ?string $maxHeight = '400px';

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => __('lang.sales'),
                    'data' => [12500, 19200, 15800, 22500, 28000, 24500, 31000, 35200, 29800, 38500, 42000, 45000],
                    'backgroundColor' => 'rgba(34, 197, 94, 0.2)',
                    'borderColor' => 'rgb(34, 197, 94)',
                    'borderWidth' => 2,
                    'fill' => 'start',
                    'tension' => 0.4,
                ],
            ],
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
