<x-filament-panels::page>
    <style>
        .report-stats-grid-4 {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        @media (max-width: 1024px) {
            .report-stats-grid-4 {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 640px) {
            .report-stats-grid-4 {
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
    <div class="report-stats-grid-4">
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

        {{-- Balance --}}
        <div class="report-stat-card" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);">
            <div class="report-stat-card-inner">
                <div>
                    <p class="report-stat-label">{{ __('lang.total_balance') }}</p>
                    <p class="report-stat-value">{{ number_format($summary['total_balance'], 2) }}</p>
                </div>
                <div class="report-icon-wrapper">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="report-icon">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v17.25m0 0c-1.472 0-2.882.265-4.185.75M12 20.25c1.472 0 2.882.265 4.185.75M18.75 4.97A48.416 48.416 0 0 0 12 4.5c-2.291 0-4.545.16-6.75.47m13.5 0c1.01.143 2.01.317 3 .52m-3-.52 2.62 10.726c.122.499-.106 1.028-.589 1.202a5.988 5.988 0 0 1-2.031.352 5.988 5.988 0 0 1-2.031-.352c-.483-.174-.711-.703-.59-1.202L18.75 4.971Zm-16.5.52c.99-.203 1.99-.377 3-.52m0 0 2.62 10.726c.122.499-.106 1.028-.589 1.202a5.989 5.989 0 0 1-2.031.352 5.989 5.989 0 0 1-2.031-.352c-.483-.174-.711-.703-.59-1.202L5.25 4.971Z" />
                    </svg>
                </div>
            </div>
        </div>

        {{-- Categories Count --}}
        <div class="report-stat-card" style="background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);">
            <div class="report-stat-card-inner">
                <div>
                    <p class="report-stat-label">{{ __('lang.categories_count') }}</p>
                    <p class="report-stat-value">{{ number_format($summary['categories_count']) }}</p>
                </div>
                <div class="report-icon-wrapper">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="report-icon">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.429 9.75 2.25 12l4.179 2.25m0-4.5 5.571 3 5.571-3m-11.142 0L2.25 7.5 12 2.25l9.75 5.25-4.179 2.25m0 0L21.75 12l-4.179 2.25m0 0 4.179 2.25L12 21.75 2.25 16.5l4.179-2.25m11.142 0-5.571 3-5.571-3" />
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