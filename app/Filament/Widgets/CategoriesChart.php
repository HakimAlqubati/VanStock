<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Illuminate\Contracts\Support\Htmlable;

class CategoriesChart extends ChartWidget
{
    protected ?string $heading = 'Categories Distribution';

    public function getHeading(): string | Htmlable | null
    {
        return __('lang.categories_distribution');
    }

    protected static ?int $sort = 4;
    protected ?string $maxHeight = '400px';

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Categories',
                    'data' => [30, 25, 20, 15, 10],
                    'backgroundColor' => [
                        'rgb(255, 99, 132)',
                        'rgb(54, 162, 235)',
                        'rgb(255, 205, 86)',
                        'rgb(75, 192, 192)',
                        'rgb(153, 102, 255)',
                    ],
                ],
            ],
            'labels' => [
                __('lang.spices'),
                __('lang.herbs'),
                __('lang.seasonings'),
                __('lang.blends'),
                __('lang.others'),
            ],
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
