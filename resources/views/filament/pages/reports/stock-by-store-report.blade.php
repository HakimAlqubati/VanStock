<x-filament-panels::page>
    <style>
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

        .report-table .row-number {
            color: #6b7280;
            font-weight: 500;
        }

        .report-table .store-name {
            font-weight: 600;
            color: #111827;
        }

        .report-table .product-name {
            font-weight: 500;
            color: #374151;
        }

        .report-table .unit-badge {
            display: inline-block;
            padding: 0.25rem 0.5rem;
            background: #e5e7eb;
            border-radius: 0.375rem;
            font-size: 0.75rem;
            color: #4b5563;
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

        .dark .report-table .store-name,
        .dark .report-table .product-name {
            color: #f3f4f6;
        }

        .dark .report-table .unit-badge {
            background: #374151;
            color: #d1d5db;
        }

        .dark .report-table tbody tr:hover {
            background-color: #374151;
        }
    </style>


    <div class="report-filters">
        <form wire:submit="applyFilters">
            {{ $this->form }}
            <div class="report-filters-buttons">
                <x-filament::button type="submit" icon="heroicon-o-funnel">
                    {{ __('lang.apply_filters') }}
                </x-filament::button>
                <x-filament::button type="button" color="gray" wire:click="resetFilters" icon="heroicon-o-x-mark">
                    {{ __('lang.reset_filters') }}
                </x-filament::button>
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
                        <th>{{ __('lang.store') }}</th>
                        <th>{{ __('lang.product') }}</th>
                        <th>{{ __('lang.unit') }}</th>
                        <th class="text-end">{{ __('lang.balance') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $index => $item)
                    <tr class="{{ $loop->even ? 'even-row' : '' }}">
                        <td class="row-number">{{ $index + 1 }}</td>
                        <td class="store-name">{{ $item->storeName }}</td>
                        <td class="product-name">{{ $item->productName }}</td>
                        <td><span class="unit-badge">{{ $item->unitName }}</span></td>
                        <td class="text-end {{ $item->balance > 0 ? 'balance-positive' : ($item->balance < 0 ? 'balance-negative' : 'balance-zero') }}">{{ number_format($item->balance, 2) }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5">
                            <div class="report-empty">
                                <p class="report-empty-title">{{ __('lang.no_data') }}</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>

            </table>
        </div>
    </div>
</x-filament-panels::page>