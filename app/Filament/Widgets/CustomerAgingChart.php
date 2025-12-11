<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Illuminate\Contracts\Support\Htmlable;

class CustomerAgingChart extends ChartWidget
{
    protected   ?string $heading = 'Customer Aging Analysis';

    protected static ?int $sort = 1;

    protected   ?string $maxHeight = '350px';

    // Full width on dashboard
    protected int|string|array $columnSpan = 'full';

    public function getHeading(): string | Htmlable | null
    {
        return __('lang.customer_aging_analysis') ?? 'تحليل أعمار ديون العملاء';
    }

    protected function getData(): array
    {
        // بيانات تجريبية لـ 6 محلات تجارية يمنية
        $customers = [
            'مؤسسة الحديدة التجارية',
            'محلات صنعاء المركزية',
            'مؤسسة تعز للتوزيع',
            'متجر عدن الكبير',
            'مؤسسة ذمار للبهارات',
            'محلات المكلا التجارية',
        ];

        // فئات الأعمار بالأيام
        $agingCategories = [
            '0-30 يوم',
            '31-60 يوم',
            '61-90 يوم',
            'أكثر من 90 يوم',
        ];

        // بيانات عشوائية واقعية لكل محل تجاري في كل فئة عمرية
        $customersData = [
            // مؤسسة الحديدة التجارية
            [
                'current' => 15000,   // 0-30 يوم
                'days_30' => 8000,    // 31-60 يوم
                'days_60' => 5000,    // 61-90 يوم
                'days_90' => 2000,    // أكثر من 90 يوم
            ],
            // محلات صنعاء المركزية
            [
                'current' => 22000,
                'days_30' => 12000,
                'days_60' => 0,
                'days_90' => 0,
            ],
            // مؤسسة تعز للتوزيع
            [
                'current' => 8000,
                'days_30' => 15000,
                'days_60' => 10000,
                'days_90' => 7000,
            ],
            // متجر عدن الكبير
            [
                'current' => 18000,
                'days_30' => 5000,
                'days_60' => 3000,
                'days_90' => 0,
            ],
            // مؤسسة ذمار للبهارات
            [
                'current' => 25000,
                'days_30' => 0,
                'days_60' => 0,
                'days_90' => 0,
            ],
            // محلات المكلا التجارية
            [
                'current' => 5000,
                'days_30' => 8000,
                'days_60' => 12000,
                'days_90' => 15000,
            ],
        ];

        // تجميع البيانات لكل فئة عمرية
        $datasets = [
            [
                'label' => '0-30 يوم (حالية)',
                'data' => array_column($customersData, 'current'),
                'backgroundColor' => 'rgba(34, 197, 94, 0.7)', // أخضر
                'borderColor' => 'rgb(34, 197, 94)',
                'borderWidth' => 1,
            ],
            [
                'label' => '31-60 يوم',
                'data' => array_column($customersData, 'days_30'),
                'backgroundColor' => 'rgba(234, 179, 8, 0.7)', // أصفر
                'borderColor' => 'rgb(234, 179, 8)',
                'borderWidth' => 1,
            ],
            [
                'label' => '61-90 يوم',
                'data' => array_column($customersData, 'days_60'),
                'backgroundColor' => 'rgba(249, 115, 22, 0.7)', // برتقالي
                'borderColor' => 'rgb(249, 115, 22)',
                'borderWidth' => 1,
            ],
            [
                'label' => 'أكثر من 90 يوم',
                'data' => array_column($customersData, 'days_90'),
                'backgroundColor' => 'rgba(239, 68, 68, 0.7)', // أحمر
                'borderColor' => 'rgb(239, 68, 68)',
                'borderWidth' => 1,
            ],
        ];

        return [
            'datasets' => $datasets,
            'labels' => $customers,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }



    public function getDescription(): ?string
    {
        return 'تحليل شامل لأعمار ديون العملاء موزعة حسب الفترات الزمنية';
    }
}
