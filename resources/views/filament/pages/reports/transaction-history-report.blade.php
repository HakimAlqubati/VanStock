<x-filament-panels::page>
    {{-- Header Stats --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        @php
        $summary = $this->getReportSummary();
        @endphp

        {{-- Total In --}}
        <div class="bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-emerald-100 text-sm font-medium">{{ __('lang.total_quantity_in') }}</p>
                    <p class="text-3xl font-bold mt-1">{{ number_format($summary['total_in'], 2) }}</p>
                </div>
                <div class="bg-white/20 rounded-full p-3">
                    <x-heroicon-o-arrow-down-circle class="w-8 h-8" />
                </div>
            </div>
        </div>

        {{-- Total Out --}}
        <div class="bg-gradient-to-br from-rose-500 to-rose-600 rounded-xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-rose-100 text-sm font-medium">{{ __('lang.total_quantity_out') }}</p>
                    <p class="text-3xl font-bold mt-1">{{ number_format($summary['total_out'], 2) }}</p>
                </div>
                <div class="bg-white/20 rounded-full p-3">
                    <x-heroicon-o-arrow-up-circle class="w-8 h-8" />
                </div>
            </div>
        </div>

        {{-- Transactions Count --}}
        <div class="bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-indigo-100 text-sm font-medium">{{ __('lang.transactions_count') }}</p>
                    <p class="text-3xl font-bold mt-1">{{ number_format($summary['transactions_count']) }}</p>
                </div>
                <div class="bg-white/20 rounded-full p-3">
                    <x-heroicon-o-clock class="w-8 h-8" />
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

    {{-- Table --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        {{ $this->table }}
    </div>
</x-filament-panels::page>