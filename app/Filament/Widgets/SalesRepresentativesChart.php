<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Illuminate\Contracts\Support\Htmlable;

class SalesRepresentativesChart extends ChartWidget
{
    protected ?string $heading = 'Sales Representatives Performance';

    public function getHeading(): string | Htmlable | null
    {
        return __('lang.sales_representatives_performance');
    }

    protected static ?int $sort = 5;
    protected ?string $maxHeight = '400px';

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => __('lang.sales'),
                    'data' => [150, 120, 200, 180, 95, 160, 140, 175, 130, 190],
                    'backgroundColor' => 'rgba(75, 192, 192, 0.2)',
                    'borderColor' => 'rgb(75, 192, 192)',
                    'borderWidth' => 2,
                ],
            ],
            'labels' => [
                'محمد أحمد',
                'علي حسن',
                'أحمد محمود',
                'يوسف عبدالله',
                'خالد عمر',
                'عمر سالم',
                'سالم ناصر',
                'ناصر علي',
                'حسن محمد',
                'عبدالله أحمد',
            ],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getOptions(): array
    {
        return [
            'indexAxis' => 'y',
            'plugins' => [
                'legend' => [
                    'display' => true,
                ],
            ],
        ];
    }
}
