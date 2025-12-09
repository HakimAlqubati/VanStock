<x-filament-panels::page>
    {{-- Header Stats --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        @php
        $summary = $this->getReportSummary();
        @endphp

        {{-- Total In --}}
        <div style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);" class="rounded-xl p-5 text-white shadow-lg">
            <div class="flex items-center gap-4">
                <div style="background: rgba(255,255,255,0.2);" class="rounded-full p-3">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m9 12.75 3 3m0 0 3-3m-3 3v-7.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>
                <div>
                    <p style="color: rgba(255,255,255,0.8);" class="text-sm font-medium">{{ __('lang.total_quantity_in') }}</p>
                    <p class="text-2xl font-bold">{{ number_format($summary['total_in'], 2) }}</p>
                </div>
            </div>
        </div>

        {{-- Total Out --}}
        <div style="background: linear-gradient(135deg, #f43f5e 0%, #e11d48 100%);" class="rounded-xl p-5 text-white shadow-lg">
            <div class="flex items-center gap-4">
                <div style="background: rgba(255,255,255,0.2);" class="rounded-full p-3">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m15 11.25-3-3m0 0-3 3m3-3v7.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>
                <div>
                    <p style="color: rgba(255,255,255,0.8);" class="text-sm font-medium">{{ __('lang.total_quantity_out') }}</p>
                    <p class="text-2xl font-bold">{{ number_format($summary['total_out'], 2) }}</p>
                </div>
            </div>
        </div>

        {{-- Balance --}}
        <div style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);" class="rounded-xl p-5 text-white shadow-lg">
            <div class="flex items-center gap-4">
                <div style="background: rgba(255,255,255,0.2);" class="rounded-full p-3">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v17.25m0 0c-1.472 0-2.882.265-4.185.75M12 20.25c1.472 0 2.882.265 4.185.75M18.75 4.97A48.416 48.416 0 0 0 12 4.5c-2.291 0-4.545.16-6.75.47m13.5 0c1.01.143 2.01.317 3 .52m-3-.52 2.62 10.726c.122.499-.106 1.028-.589 1.202a5.988 5.988 0 0 1-2.031.352 5.988 5.988 0 0 1-2.031-.352c-.483-.174-.711-.703-.59-1.202L18.75 4.971Zm-16.5.52c.99-.203 1.99-.377 3-.52m0 0 2.62 10.726c.122.499-.106 1.028-.589 1.202a5.989 5.989 0 0 1-2.031.352 5.989 5.989 0 0 1-2.031-.352c-.483-.174-.711-.703-.59-1.202L5.25 4.971Z" />
                    </svg>
                </div>
                <div>
                    <p style="color: rgba(255,255,255,0.8);" class="text-sm font-medium">{{ __('lang.total_balance') }}</p>
                    <p class="text-2xl font-bold">{{ number_format($summary['total_balance'], 2) }}</p>
                </div>
            </div>
        </div>

        {{-- Items Count --}}
        <div style="background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);" class="rounded-xl p-5 text-white shadow-lg">
            <div class="flex items-center gap-4">
                <div style="background: rgba(255,255,255,0.2);" class="rounded-full p-3">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 7.5-9-5.25L3 7.5m18 0-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9" />
                    </svg>
                </div>
                <div>
                    <p style="color: rgba(255,255,255,0.8);" class="text-sm font-medium">{{ __('lang.items_count') }}</p>
                    <p class="text-2xl font-bold">{{ number_format($summary['items_count']) }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Filters --}}
    <div class="mb-6">
        <form wire:submit="$refresh">
            {{ $this->form }}
            <div class="mt-4 flex gap-2">
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
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
        @php
        $data = $this->getReportData();
        @endphp

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                {{-- Table Header --}}
                <thead style="background: linear-gradient(135deg, #1e293b 0%, #334155 100%);">
                    <tr>
                        <th class="px-4 py-4 text-start text-xs font-semibold text-white uppercase tracking-wider">
                            #
                        </th>
                        <th class="px-4 py-4 text-start text-xs font-semibold text-white uppercase tracking-wider">
                            {{ __('lang.product') }}
                        </th>
                        <th class="px-4 py-4 text-start text-xs font-semibold text-white uppercase tracking-wider">
                            {{ __('lang.store') }}
                        </th>
                        <th class="px-4 py-4 text-start text-xs font-semibold text-white uppercase tracking-wider">
                            {{ __('lang.category') }}
                        </th>
                        <th class="px-4 py-4 text-end text-xs font-semibold text-white uppercase tracking-wider">
                            {{ __('lang.quantity_in') }}
                        </th>
                        <th class="px-4 py-4 text-end text-xs font-semibold text-white uppercase tracking-wider">
                            {{ __('lang.quantity_out') }}
                        </th>
                        <th class="px-4 py-4 text-end text-xs font-semibold text-white uppercase tracking-wider">
                            {{ __('lang.balance') }}
                        </th>
                        <th class="px-4 py-4 text-center text-xs font-semibold text-white uppercase tracking-wider">
                            {{ __('lang.unit') }}
                        </th>
                    </tr>
                </thead>

                {{-- Table Body --}}
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($data as $index => $item)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors {{ $loop->even ? 'bg-gray-50/50 dark:bg-gray-800/50' : '' }}">
                        <td class="px-4 py-3 text-gray-500 dark:text-gray-400 font-medium">
                            {{ $index + 1 }}
                        </td>
                        <td class="px-4 py-3 font-semibold text-gray-900 dark:text-white">
                            {{ $item->productName }}
                        </td>
                        <td class="px-4 py-3">
                            <span style="background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%); color: #1e40af;" class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold">
                                {{ $item->storeName }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            <span style="background: #f3f4f6; color: #374151;" class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium">
                                {{ $item->categoryName ?? '-' }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-end font-semibold" style="color: #059669;">
                            {{ number_format($item->quantityIn, 2) }}
                        </td>
                        <td class="px-4 py-3 text-end font-semibold" style="color: #dc2626;">
                            {{ number_format($item->quantityOut, 2) }}
                        </td>
                        <td class="px-4 py-3 text-end font-bold" style="color: {{ $item->balance > 0 ? '#059669' : ($item->balance < 0 ? '#dc2626' : '#6b7280') }};">
                            {{ number_format($item->balance, 2) }}
                        </td>
                        <td class="px-4 py-3 text-center">
                            <span style="background: linear-gradient(135deg, #ede9fe 0%, #ddd6fe 100%); color: #5b21b6;" class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold">
                                {{ $item->unitName ?? '-' }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-4 py-12 text-center text-gray-500 dark:text-gray-400">
                            <div class="flex flex-col items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-16 h-16 text-gray-300 mb-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5m6 4.125 2.25 2.25m0 0 2.25 2.25M12 13.875l2.25-2.25M12 13.875l-2.25 2.25M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                                </svg>
                                <p class="text-lg font-semibold text-gray-600">{{ __('lang.no_data') }}</p>
                                <p class="text-sm text-gray-400">{{ __('lang.try_different_filters') }}</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>

                {{-- Table Footer --}}
                @if($data->count() > 0)
                <tfoot style="background: linear-gradient(135deg, #1e293b 0%, #334155 100%);">
                    <tr class="text-white font-bold">
                        <td colspan="4" class="px-4 py-4">
                            {{ __('lang.total') }} ({{ $data->count() }} {{ __('lang.items_count') }})
                        </td>
                        <td class="px-4 py-4 text-end" style="color: #4ade80;">
                            {{ number_format($summary['total_in'], 2) }}
                        </td>
                        <td class="px-4 py-4 text-end" style="color: #fb7185;">
                            {{ number_format($summary['total_out'], 2) }}
                        </td>
                        <td class="px-4 py-4 text-end" style="color: {{ $summary['total_balance'] > 0 ? '#4ade80' : '#fb7185' }};">
                            {{ number_format($summary['total_balance'], 2) }}
                        </td>
                        <td class="px-4 py-4"></td>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>
    </div>
</x-filament-panels::page>