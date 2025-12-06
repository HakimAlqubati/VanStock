<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Illuminate\Contracts\Support\Htmlable;

class ProductsChart extends ChartWidget
{
    protected ?string $heading = 'Products per Month';

    public function getHeading(): string | Htmlable | null
    {
        return __('lang.products_per_month');
    }

    protected static ?int $sort = 3;
    protected ?string $maxHeight = '400px';

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Products',
                    'data' => [12, 19, 15, 25, 32, 28, 45, 52, 48, 60, 72, 85],
                    'backgroundColor' => [
                        'rgba(54, 162, 235, 0.2)',
                    ],
                    'borderColor' => [
                        'rgb(54, 162, 235)',
                    ],
                    'borderWidth' => 1,
                ],
            ],
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
