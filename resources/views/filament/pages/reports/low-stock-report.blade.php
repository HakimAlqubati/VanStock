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

        .report-table-scroll {
            overflow-x: auto;
        }

        .report-table {
            width: 100%;
            font-size: 0.875rem;
            border-collapse: collapse;
        }

        .report-table thead {
            background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
        }

        .report-table th {
            padding: 1rem;
            text-align: start;
            font-size: 0.75rem;
            font-weight: 600;
            color: white;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .report-table th.text-end {
            text-align: end;
        }

        .report-table th.text-center {
            text-align: center;
        }

        .report-table tbody tr {
            border-bottom: 1px solid #e5e7eb;
            transition: background-color 0.15s;
        }

        .dark .report-table tbody tr {
            border-color: #374151;
        }

        .report-table tbody tr:hover {
            background-color: #f9fafb;
        }

        .dark .report-table tbody tr:hover {
            background-color: rgba(55, 65, 81, 0.3);
        }

        .report-table tbody tr.even-row {
            background-color: rgba(249, 250, 251, 0.5);
        }

        .dark .report-table tbody tr.even-row {
            background-color: rgba(31, 41, 55, 0.5);
        }

        .report-table td {
            padding: 0.75rem 1rem;
        }

        .report-table td.text-end {
            text-align: end;
        }

        .report-table td.text-center {
            text-align: center;
        }

        .report-table .row-number {
            color: #6b7280;
            font-weight: 500;
        }

        .report-table .product-name {
            font-weight: 600;
            color: #111827;
        }

        .dark .report-table .product-name {
            color: white;
        }

        .report-table .badge {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .report-table .badge-store {
            background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
            color: #1e40af;
        }

        .report-table .badge-category {
            background: #f3f4f6;
            color: #374151;
        }

        .report-table .badge-unit {
            background: linear-gradient(135deg, #ede9fe 0%, #ddd6fe 100%);
            color: #5b21b6;
        }

        .report-table .badge-danger {
            background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
            color: #991b1b;
        }

        .report-table .badge-warning {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            color: #92400e;
        }

        .report-table .qty-in {
            color: #059669;
            font-weight: 600;
        }

        .report-table .qty-out {
            color: #dc2626;
            font-weight: 600;
        }

        .report-table .balance-positive {
            color: #059669;
            font-weight: 700;
        }

        .report-table .balance-negative {
            color: #dc2626;
            font-weight: 700;
        }

        .report-table .balance-zero {
            color: #6b7280;
            font-weight: 700;
        }

        .report-table tfoot {
            background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
        }

        .report-table tfoot td {
            padding: 1rem;
            color: white;
            font-weight: 700;
        }

        .report-table tfoot .total-in {
            color: #4ade80;
        }

        .report-table tfoot .total-out {
            color: #fb7185;
        }

        .report-empty {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 3rem 1rem;
            color: #6b7280;
        }

        .report-empty-icon {
            width: 64px;
            height: 64px;
            color: #d1d5db;
            margin-bottom: 1rem;
        }

        .report-empty-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: #4b5563;
            margin: 0;
        }

        .report-empty-subtitle {
            font-size: 0.875rem;
            color: #9ca3af;
            margin: 0.5rem 0 0 0;
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

    {{-- Custom Table --}}
    <div class="report-table-wrapper">
        @php
        $data = $this->getReportData();
        @endphp

        <div class="report-table-scroll">
            <table class="report-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>{{ __('lang.product') }}</th>
                        <th>{{ __('lang.store') }}</th>
                        <th>{{ __('lang.category') }}</th>
                        <th class="text-end">{{ __('lang.quantity_in') }}</th>
                        <th class="text-end">{{ __('lang.quantity_out') }}</th>
                        <th class="text-end">{{ __('lang.balance') }}</th>
                        <th class="text-center">{{ __('lang.unit') }}</th>
                        <th class="text-center">{{ __('lang.status') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $index => $item)
                    <tr class="{{ $loop->even ? 'even-row' : '' }}">
                        <td class="row-number">{{ $index + 1 }}</td>
                        <td class="product-name">{{ $item->productName }}</td>
                        <td><span class="badge badge-store">{{ $item->storeName }}</span></td>
                        <td><span class="badge badge-category">{{ $item->categoryName ?? '-' }}</span></td>
                        <td class="text-end qty-in">{{ number_format($item->quantityIn, 2) }}</td>
                        <td class="text-end qty-out">{{ number_format($item->quantityOut, 2) }}</td>
                        <td class="text-end {{ $item->balance > 0 ? 'balance-positive' : ($item->balance < 0 ? 'balance-negative' : 'balance-zero') }}">
                            {{ number_format($item->balance, 2) }}
                        </td>
                        <td class="text-center"><span class="badge badge-unit">{{ $item->unitName ?? '-' }}</span></td>
                        <td class="text-center">
                            @if($item->balance <= 0)
                                <span class="badge badge-danger">{{ __('lang.out_of_stock') }}</span>
                                @else
                                <span class="badge badge-warning">{{ __('lang.low_stock') }}</span>
                                @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9">
                            <div class="report-empty">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="report-empty-icon">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5m6 4.125 2.25 2.25m0 0 2.25 2.25M12 13.875l2.25-2.25M12 13.875l-2.25 2.25M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                                </svg>
                                <p class="report-empty-title">{{ __('lang.no_data') }}</p>
                                <p class="report-empty-subtitle">{{ __('lang.try_different_filters') }}</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
                @if($data->count() > 0)
                <tfoot>
                    <tr>
                        <td colspan="9">{{ __('lang.total') }} ({{ $data->count() }} {{ __('lang.items_count') }})</td>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>
    </div>
</x-filament-panels::page>