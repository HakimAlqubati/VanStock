<x-filament-panels::page>
    {{-- Header Stats --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        @php
        $summary = $this->getReportSummary();
        @endphp

        {{-- Out of Stock --}}
        <div class="bg-gradient-to-br from-red-500 to-red-600 rounded-xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-red-100 text-sm font-medium">{{ __('lang.out_of_stock') }}</p>
                    <p class="text-3xl font-bold mt-1">{{ number_format($summary['out_of_stock']) }}</p>
                </div>
                <div class="bg-white/20 rounded-full p-3">
                    <x-heroicon-o-x-circle class="w-8 h-8" />
                </div>
            </div>
        </div>

        {{-- Low Stock --}}
        <div class="bg-gradient-to-br from-amber-500 to-amber-600 rounded-xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-amber-100 text-sm font-medium">{{ __('lang.low_stock') }}</p>
                    <p class="text-3xl font-bold mt-1">{{ number_format($summary['low_stock']) }}</p>
                </div>
                <div class="bg-white/20 rounded-full p-3">
                    <x-heroicon-o-exclamation-triangle class="w-8 h-8" />
                </div>
            </div>
        </div>

        {{-- Total Items --}}
        <div class="bg-gradient-to-br from-gray-600 to-gray-700 rounded-xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-300 text-sm font-medium">{{ __('lang.total_items_below') }} {{ $summary['threshold'] }}</p>
                    <p class="text-3xl font-bold mt-1">{{ number_format($summary['total_items']) }}</p>
                </div>
                <div class="bg-white/20 rounded-full p-3">
                    <x-heroicon-o-cube class="w-8 h-8" />
                </div>
            </div>
        </div>
    </div>

    {{-- Alert Banner --}}
    @if($summary['out_of_stock'] > 0)
    <div class="mb-6 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl p-4">
        <div class="flex items-center gap-3">
            <x-heroicon-o-exclamation-triangle class="w-6 h-6 text-red-600 dark:text-red-400" />
            <div>
                <h4 class="font-semibold text-red-800 dark:text-red-200">{{ __('lang.attention_required') }}</h4>
                <p class="text-red-600 dark:text-red-300 text-sm">{{ __('lang.out_of_stock_warning', ['count' => $summary['out_of_stock']]) }}</p>
            </div>
        </div>
    </div>
    @endif

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