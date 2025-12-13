<x-filament-panels::page>
    <style>
        .report-stats-grid-3 {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        @media (max-width: 768px) {
            .report-stats-grid-3 {
                grid-template-columns: 1fr;
            }
        }

        .report-stat-card {
            border-radius: 0.75rem;
            padding: 1.5rem;
            color: white;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }

        .report-stat-card-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .report-stat-label {
            font-size: 0.875rem;
            font-weight: 500;
            margin: 0;
            opacity: 0.9;
        }

        .report-stat-value {
            font-size: 1.875rem;
            font-weight: 700;
            margin: 0.25rem 0 0 0;
        }

        .report-icon-wrapper {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 9999px;
            padding: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .report-icon {
            width: 32px;
            height: 32px;
            flex-shrink: 0;
        }

        .report-alert-banner {
            margin-bottom: 1.5rem;
            background: #fef2f2;
            border: 1px solid #fecaca;
            border-radius: 0.75rem;
            padding: 1rem;
        }

        .dark .report-alert-banner {
            background: rgba(127, 29, 29, 0.2);
            border-color: rgba(153, 27, 27, 0.5);
        }

        .report-alert-inner {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .report-alert-icon {
            width: 24px;
            height: 24px;
            color: #dc2626;
            flex-shrink: 0;
        }

        .dark .report-alert-icon {
            color: #f87171;
        }

        .report-alert-title {
            font-weight: 600;
            color: #991b1b;
            margin: 0;
        }

        .dark .report-alert-title {
            color: #fecaca;
        }

        .report-alert-text {
            font-size: 0.875rem;
            color: #dc2626;
            margin: 0;
        }

        .dark .report-alert-text {
            color: #fca5a5;
        }

        .report-filters {
            margin-bottom: 1.5rem;
        }

        .report-filters-buttons {
            margin-top: 1rem;
            display: flex;
            gap: 0.5rem;
        }

        .report-table-wrapper {
            background: white;
            border-radius: 0.75rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            border: 1px solid #e5e7eb;
            overflow: hidden;
        }

        .dark .report-table-wrapper {
            background: #1f2937;
            border-color: #374151;
        }
    </style>

    {{-- Header Stats --}}
    <div class="report-stats-grid-3">
        @php
        $summary = $this->getReportSummary();
        @endphp

        {{-- Out of Stock --}}
        <div class="report-stat-card" style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);">
            <div class="report-stat-card-inner">
                <div>
                    <p class="report-stat-label">{{ __('lang.out_of_stock') }}</p>
                    <p class="report-stat-value">{{ number_format($summary['out_of_stock']) }}</p>
                </div>
                <div class="report-icon-wrapper">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="report-icon">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>
            </div>
        </div>

        {{-- Low Stock --}}
        <div class="report-stat-card" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
            <div class="report-stat-card-inner">
                <div>
                    <p class="report-stat-label">{{ __('lang.low_stock') }}</p>
                    <p class="report-stat-value">{{ number_format($summary['low_stock']) }}</p>
                </div>
                <div class="report-icon-wrapper">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="report-icon">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                    </svg>
                </div>
            </div>
        </div>

        {{-- Total Items --}}
        <div class="report-stat-card" style="background: linear-gradient(135deg, #4b5563 0%, #374151 100%);">
            <div class="report-stat-card-inner">
                <div>
                    <p class="report-stat-label">{{ __('lang.total_items_below') }} {{ $summary['threshold'] }}</p>
                    <p class="report-stat-value">{{ number_format($summary['total_items']) }}</p>
                </div>
                <div class="report-icon-wrapper">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="report-icon">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 7.5-9-5.25L3 7.5m18 0-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    {{-- Alert Banner --}}
    @if($summary['out_of_stock'] > 0)
    <div class="report-alert-banner">
        <div class="report-alert-inner">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="report-alert-icon">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
            </svg>
            <div>
                <h4 class="report-alert-title">{{ __('lang.attention_required') }}</h4>
                <p class="report-alert-text">{{ __('lang.out_of_stock_warning', ['count' => $summary['out_of_stock']]) }}</p>
            </div>
        </div>
    </div>
    @endif

    {{-- Filters --}}
    <div class="report-filters">
        <form wire:submit="$refresh">
            {{ $this->form }}
            <div class="report-filters-buttons">
                <x-filament::button type="submit" icon="heroicon-o-funnel">
                    {{ __('lang.apply_filters') }}
                </x-filament::button>
                <x-filament::button type="button" color="gray" wire:click="$set('filters', [])" icon="heroicon-o-x-mark">
                    {{ __('lang.reset_filters') }}
                </x-filament::button>
            </div>
        </form>
    </div>

    {{-- Table --}}
    <div class="report-table-wrapper">
        {{ $this->table }}
    </div>
</x-filament-panels::page>