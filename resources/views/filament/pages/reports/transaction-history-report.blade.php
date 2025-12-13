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

        {{-- Total In --}}
        <div class="report-stat-card" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
            <div class="report-stat-card-inner">
                <div>
                    <p class="report-stat-label">{{ __('lang.total_quantity_in') }}</p>
                    <p class="report-stat-value">{{ number_format($summary['total_in'], 2) }}</p>
                </div>
                <div class="report-icon-wrapper">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="report-icon">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m9 12.75 3 3m0 0 3-3m-3 3v-7.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>
            </div>
        </div>

        {{-- Total Out --}}
        <div class="report-stat-card" style="background: linear-gradient(135deg, #f43f5e 0%, #e11d48 100%);">
            <div class="report-stat-card-inner">
                <div>
                    <p class="report-stat-label">{{ __('lang.total_quantity_out') }}</p>
                    <p class="report-stat-value">{{ number_format($summary['total_out'], 2) }}</p>
                </div>
                <div class="report-icon-wrapper">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="report-icon">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m15 11.25-3-3m0 0-3 3m3-3v7.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>
            </div>
        </div>

        {{-- Transactions Count --}}
        <div class="report-stat-card" style="background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);">
            <div class="report-stat-card-inner">
                <div>
                    <p class="report-stat-label">{{ __('lang.transactions_count') }}</p>
                    <p class="report-stat-value">{{ number_format($summary['transactions_count']) }}</p>
                </div>
                <div class="report-icon-wrapper">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="report-icon">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

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