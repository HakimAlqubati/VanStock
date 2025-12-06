<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Illuminate\Contracts\Support\Htmlable;

class Top5ProductsSalesChart extends ChartWidget
{
    protected ?string $heading = 'Top 5 Products Sales';

    public function getHeading(): string | Htmlable | null
    {
        return __('lang.top_5_products_sales');
    }

    protected static ?int $sort = 7;
    protected ?string $maxHeight = '400px';

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => __('lang.sales'),
                    'data' => [4500, 3800, 3200, 2900, 2500],
                    'backgroundColor' => [
                        'rgb(255, 99, 132)',
                        'rgb(255, 159, 64)',
                        'rgb(255, 205, 86)',
                        'rgb(75, 192, 192)',
                        'rgb(54, 162, 235)',
                    ],
                ],
            ],
            'labels' => [
                'كمون مطحون',
                'كركم طبيعي',
                'فلفل أسود',
                'بهارات مشكلة',
                'زنجبيل مطحون',
            ],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
