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
        }

        .report-table th.text-end {
            text-align: end;
        }

        .report-table th.text-center {
            text-align: center;
        }

        .report-table tbody tr {
            border-bottom: 1px solid #e5e7eb;
        }

        .report-table tbody tr:hover {
            background-color: #f9fafb;
        }

        .report-table tbody tr.even-row {
            background-color: rgba(249, 250, 251, 0.5);
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

        .report-table .badge {
            display: inline-flex;
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

        .report-table .qty-in {
            color: #059669;
            font-weight: 600;
        }

        .report-table .qty-out {
            color: #dc2626;
            font-weight: 600;
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

        .report-empty-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: #4b5563;
            margin: 0;
        }
    </style>

    <div class="report-stats-grid-3">
        @php $summary = $this->getReportSummary(); @endphp
        <div class="report-stat-card" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
            <div class="report-stat-card-inner">
                <div>
                    <p class="report-stat-label">{{ __('lang.total_quantity_in') }}</p>
                    <p class="report-stat-value">{{ number_format($summary['total_in'], 2) }}</p>
                </div>
                <div class="report-icon-wrapper"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="report-icon">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m9 12.75 3 3m0 0 3-3m-3 3v-7.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg></div>
            </div>
        </div>
        <div class="report-stat-card" style="background: linear-gradient(135deg, #f43f5e 0%, #e11d48 100%);">
            <div class="report-stat-card-inner">
                <div>
                    <p class="report-stat-label">{{ __('lang.total_quantity_out') }}</p>
                    <p class="report-stat-value">{{ number_format($summary['total_out'], 2) }}</p>
                </div>
                <div class="report-icon-wrapper"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="report-icon">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m15 11.25-3-3m0 0-3 3m3-3v7.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg></div>
            </div>
        </div>
        <div class="report-stat-card" style="background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);">
            <div class="report-stat-card-inner">
                <div>
                    <p class="report-stat-label">{{ __('lang.transactions_count') }}</p>
                    <p class="report-stat-value">{{ number_format($summary['transactions_count']) }}</p>
                </div>
                <div class="report-icon-wrapper"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="report-icon">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg></div>
            </div>
        </div>
    </div>

    <div class="report-filters">
        <form wire:submit="$refresh">
            {{ $this->form }}
            <div class="report-filters-buttons">
                <x-filament::button type="submit" icon="heroicon-o-funnel">{{ __('lang.apply_filters') }}</x-filament::button>
                <x-filament::button type="button" color="gray" wire:click="$set('filters', [])" icon="heroicon-o-x-mark">{{ __('lang.reset_filters') }}</x-filament::button>
            </div>
        </form>
    </div>

    <div class="report-table-wrapper">
        @php $data = $this->getReportData(); @endphp
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
                        <th class="text-center">{{ __('lang.unit') }}</th>
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
                        <td class="text-center"><span class="badge badge-unit">{{ $item->unitName ?? '-' }}</span></td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7">
                            <div class="report-empty">
                                <p class="report-empty-title">{{ __('lang.no_data') }}</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
                @if($data->count() > 0)
                <tfoot>
                    <tr>
                        <td colspan="4">{{ __('lang.total') }} ({{ $data->count() }})</td>
                        <td class="text-end total-in">{{ number_format($summary['total_in'], 2) }}</td>
                        <td class="text-end total-out">{{ number_format($summary['total_out'], 2) }}</td>
                        <td></td>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>
    </div>
</x-filament-panels::page>