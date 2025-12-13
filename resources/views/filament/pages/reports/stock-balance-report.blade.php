<x-filament-panels::page>
    <style>
        .stock-report-stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        @media (max-width: 1024px) {
            .stock-report-stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 640px) {
            .stock-report-stats-grid {
                grid-template-columns: 1fr;
            }
        }

        .stock-report-stat-card {
            border-radius: 0.75rem;
            padding: 1.25rem;
            color: white;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }

        .stock-report-stat-card-inner {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .stock-report-icon-wrapper {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 9999px;
            padding: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .stock-report-icon {
            width: 24px;
            height: 24px;
            flex-shrink: 0;
        }

        .stock-report-stat-label {
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.875rem;
            font-weight: 500;
            margin: 0;
        }

        .stock-report-stat-value {
            font-size: 1.5rem;
            font-weight: 700;
            margin: 0;
        }
    </style>

    {{-- Header Stats --}}
    <div class="stock-report-stats-grid">
        @php
        $summary = $this->getReportSummary();
        @endphp

        {{-- Total In --}}
        <div class="stock-report-stat-card" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
            <div class="stock-report-stat-card-inner">
                <div class="stock-report-icon-wrapper">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="stock-report-icon">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m9 12.75 3 3m0 0 3-3m-3 3v-7.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>
                <div>
                    <p class="stock-report-stat-label">{{ __('lang.total_quantity_in') }}</p>
                    <p class="stock-report-stat-value">{{ number_format($summary['total_in'], 2) }}</p>
                </div>
            </div>
        </div>

        {{-- Total Out --}}
        <div class="stock-report-stat-card" style="background: linear-gradient(135deg, #f43f5e 0%, #e11d48 100%);">
            <div class="stock-report-stat-card-inner">
                <div class="stock-report-icon-wrapper">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="stock-report-icon">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m15 11.25-3-3m0 0-3 3m3-3v7.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>
                <div>
                    <p class="stock-report-stat-label">{{ __('lang.total_quantity_out') }}</p>
                    <p class="stock-report-stat-value">{{ number_format($summary['total_out'], 2) }}</p>
                </div>
            </div>
        </div>

        {{-- Balance --}}
        <div class="stock-report-stat-card" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);">
            <div class="stock-report-stat-card-inner">
                <div class="stock-report-icon-wrapper">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="stock-report-icon">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v17.25m0 0c-1.472 0-2.882.265-4.185.75M12 20.25c1.472 0 2.882.265 4.185.75M18.75 4.97A48.416 48.416 0 0 0 12 4.5c-2.291 0-4.545.16-6.75.47m13.5 0c1.01.143 2.01.317 3 .52m-3-.52 2.62 10.726c.122.499-.106 1.028-.589 1.202a5.988 5.988 0 0 1-2.031.352 5.988 5.988 0 0 1-2.031-.352c-.483-.174-.711-.703-.59-1.202L18.75 4.971Zm-16.5.52c.99-.203 1.99-.377 3-.52m0 0 2.62 10.726c.122.499-.106 1.028-.589 1.202a5.989 5.989 0 0 1-2.031.352 5.989 5.989 0 0 1-2.031-.352c-.483-.174-.711-.703-.59-1.202L5.25 4.971Z" />
                    </svg>
                </div>
                <div>
                    <p class="stock-report-stat-label">{{ __('lang.total_balance') }}</p>
                    <p class="stock-report-stat-value">{{ number_format($summary['total_balance'], 2) }}</p>
                </div>
            </div>
        </div>

        {{-- Items Count --}}
        <div class="stock-report-stat-card" style="background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);">
            <div class="stock-report-stat-card-inner">
                <div class="stock-report-icon-wrapper">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="stock-report-icon">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 7.5-9-5.25L3 7.5m18 0-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9" />
                    </svg>
                </div>
                <div>
                    <p class="stock-report-stat-label">{{ __('lang.items_count') }}</p>
                    <p class="stock-report-stat-value">{{ number_format($summary['items_count']) }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Filters --}}
    <div style="margin-bottom: 1.5rem;">
        <form wire:submit="$refresh">
            {{ $this->form }}
            <div style="margin-top: 1rem; display: flex; gap: 0.5rem;">
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
    <style>
        .stock-report-table-wrapper {
            background: white;
            border-radius: 0.75rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            border: 1px solid #e5e7eb;
            overflow: hidden;
        }

        .dark .stock-report-table-wrapper {
            background: #1f2937;
            border-color: #374151;
        }

        .stock-report-table-scroll {
            overflow-x: auto;
        }

        .stock-report-table {
            width: 100%;
            font-size: 0.875rem;
            border-collapse: collapse;
        }

        .stock-report-table thead {
            background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
        }

        .stock-report-table th {
            padding: 1rem;
            text-align: start;
            font-size: 0.75rem;
            font-weight: 600;
            color: white;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .stock-report-table th.text-end {
            text-align: end;
        }

        .stock-report-table th.text-center {
            text-align: center;
        }

        .stock-report-table tbody tr {
            border-bottom: 1px solid #e5e7eb;
            transition: background-color 0.15s;
        }

        .dark .stock-report-table tbody tr {
            border-color: #374151;
        }

        .stock-report-table tbody tr:hover {
            background-color: #f9fafb;
        }

        .dark .stock-report-table tbody tr:hover {
            background-color: rgba(55, 65, 81, 0.3);
        }

        .stock-report-table tbody tr.even-row {
            background-color: rgba(249, 250, 251, 0.5);
        }

        .dark .stock-report-table tbody tr.even-row {
            background-color: rgba(31, 41, 55, 0.5);
        }

        .stock-report-table td {
            padding: 0.75rem 1rem;
        }

        .stock-report-table td.text-end {
            text-align: end;
        }

        .stock-report-table td.text-center {
            text-align: center;
        }

        .stock-report-table .row-number {
            color: #6b7280;
            font-weight: 500;
        }

        .dark .stock-report-table .row-number {
            color: #9ca3af;
        }

        .stock-report-table .product-name {
            font-weight: 600;
            color: #111827;
        }

        .dark .stock-report-table .product-name {
            color: white;
        }

        .stock-report-table .badge {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .stock-report-table .badge-store {
            background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
            color: #1e40af;
        }

        .stock-report-table .badge-category {
            background: #f3f4f6;
            color: #374151;
        }

        .stock-report-table .badge-unit {
            background: linear-gradient(135deg, #ede9fe 0%, #ddd6fe 100%);
            color: #5b21b6;
        }

        .stock-report-table .qty-in {
            color: #059669;
            font-weight: 600;
        }

        .stock-report-table .qty-out {
            color: #dc2626;
            font-weight: 600;
        }

        .stock-report-table .balance-positive {
            color: #059669;
            font-weight: 700;
        }

        .stock-report-table .balance-negative {
            color: #dc2626;
            font-weight: 700;
        }

        .stock-report-table .balance-zero {
            color: #6b7280;
            font-weight: 700;
        }

        .stock-report-table tfoot {
            background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
        }

        .stock-report-table tfoot td {
            padding: 1rem;
            color: white;
            font-weight: 700;
        }

        .stock-report-table tfoot .total-in {
            color: #4ade80;
        }

        .stock-report-table tfoot .total-out {
            color: #fb7185;
        }

        .stock-report-table tfoot .total-balance-positive {
            color: #4ade80;
        }

        .stock-report-table tfoot .total-balance-negative {
            color: #fb7185;
        }

        .stock-report-empty {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 3rem 1rem;
            color: #6b7280;
        }

        .stock-report-empty-icon {
            width: 64px;
            height: 64px;
            color: #d1d5db;
            margin-bottom: 1rem;
        }

        .stock-report-empty-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: #4b5563;
            margin: 0;
        }

        .stock-report-empty-subtitle {
            font-size: 0.875rem;
            color: #9ca3af;
            margin: 0.5rem 0 0 0;
        }
    </style>

    <div class="stock-report-table-wrapper">
        @php
        $data = $this->getReportData();
        @endphp

        <div class="stock-report-table-scroll">
            <table class="stock-report-table">
                {{-- Table Header --}}
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
                    </tr>
                </thead>

                {{-- Table Body --}}
                <tbody>
                    @forelse($data as $index => $item)
                    <tr class="{{ $loop->even ? 'even-row' : '' }}">
                        <td class="row-number">{{ $index + 1 }}</td>
                        <td class="product-name">{{ $item->productName }}</td>
                        <td>
                            <span class="badge badge-store">{{ $item->storeName }}</span>
                        </td>
                        <td>
                            <span class="badge badge-category">{{ $item->categoryName ?? '-' }}</span>
                        </td>
                        <td class="text-end qty-in">{{ number_format($item->quantityIn, 2) }}</td>
                        <td class="text-end qty-out">{{ number_format($item->quantityOut, 2) }}</td>
                        <td class="text-end {{ $item->balance > 0 ? 'balance-positive' : ($item->balance < 0 ? 'balance-negative' : 'balance-zero') }}">
                            {{ number_format($item->balance, 2) }}
                        </td>
                        <td class="text-center">
                            <span class="badge badge-unit">{{ $item->unitName ?? '-' }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8">
                            <div class="stock-report-empty">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="stock-report-empty-icon">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5m6 4.125 2.25 2.25m0 0 2.25 2.25M12 13.875l2.25-2.25M12 13.875l-2.25 2.25M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                                </svg>
                                <p class="stock-report-empty-title">{{ __('lang.no_data') }}</p>
                                <p class="stock-report-empty-subtitle">{{ __('lang.try_different_filters') }}</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>

                {{-- Table Footer --}}
                @if($data->count() > 0)
                <tfoot>
                    <tr>
                        <td colspan="4">{{ __('lang.total') }} ({{ $data->count() }} {{ __('lang.items_count') }})</td>
                        <td class="text-end total-in">{{ number_format($summary['total_in'], 2) }}</td>
                        <td class="text-end total-out">{{ number_format($summary['total_out'], 2) }}</td>
                        <td class="text-end {{ $summary['total_balance'] > 0 ? 'total-balance-positive' : 'total-balance-negative' }}">
                            {{ number_format($summary['total_balance'], 2) }}
                        </td>
                        <td></td>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>
    </div>
</x-filament-panels::page>