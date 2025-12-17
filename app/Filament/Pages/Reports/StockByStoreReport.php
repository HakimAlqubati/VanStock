<?php

namespace App\Filament\Pages\Reports;

use App\DTOs\Inventory\InventoryFilterDTO;
use App\Services\Inventory\InventoryReportService;
use App\Models\Store;
use BackedEnum;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Contracts\Support\Htmlable;
use Livewire\Attributes\Url;
use UnitEnum;

class StockByStoreReport extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-building-storefront';

    protected string $view = 'filament.pages.reports.stock-by-store-report';

    protected static string | UnitEnum | null $navigationGroup = 'التقارير';

    protected static ?int $navigationSort = 3;

    #[Url]
    public ?array $filters = [];

    public static function getNavigationLabel(): string
    {
        return __('lang.stock_by_store_report');
    }

    public function getTitle(): string|Htmlable
    {
        return __('lang.stock_by_store_report');
    }

    public function getHeading(): string|Htmlable
    {
        return __('lang.stock_by_store_report');
    }

    public function getSubheading(): string|Htmlable|null
    {
        return __('lang.stock_by_store_report_desc');
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->statePath('filters')
            ->components([
                Section::make(__('lang.filters'))
                    ->schema([
                        Select::make('store_id')
                            ->label(__('lang.store'))
                            ->options(Store::pluck('name', 'id'))
                            ->searchable()
                            ->preload()
                            ->placeholder(__('lang.all_stores')),

                        DatePicker::make('date_from')
                            ->label(__('lang.date_from'))
                            ->native(false),

                        DatePicker::make('date_to')
                            ->label(__('lang.date_to'))
                            ->native(false),
                    ])
                    ->columns(3)
                    ->collapsible(),
            ]);
    }

    /**
     * Apply filters action - called when filter button is clicked
     */
    public function applyFilters(): void
    {
        // dd('sdf', $this->filters);
        // The form data is already bound to $this->filters via statePath
        // Just refresh the component to re-render with new filter values
        $this->dispatch('$refresh');
    }

    /**
     * Reset filters action
     */
    public function resetFilters(): void
    {
        $this->filters = [];
        $this->form->fill([]);

        $this->dispatch('$refresh');
    }


    /**
     * Get report data with product-level details
     */
    protected function getReportQuery()
    {
        $service = app(InventoryReportService::class);
        $filterDTO = InventoryFilterDTO::fromArray($this->filters ?? []);

        // Use getStockBalance to get product-level details
        $report = $service->getStockBalance($filterDTO);

        return $report->items->map(fn($item) => $item->toArray())->toArray();
    }

    public function getReportSummary(): array
    {
        $service = app(InventoryReportService::class);
        $filterDTO = InventoryFilterDTO::fromArray($this->filters ?? []);
        $report = $service->getStockBalance($filterDTO);

        // Count unique stores
        $storesCount = $report->items->unique('storeId')->count();

        return [
            'total_in' => $report->totalQuantityIn,
            'total_out' => $report->totalQuantityOut,
            'total_balance' => $report->totalBalance,
            'stores_count' => $storesCount,
            'products_count' => $report->count(),
        ];
    }

    public function getReportData()
    {
        $service = app(InventoryReportService::class);
        $filterDTO = InventoryFilterDTO::fromArray($this->filters ?? []);
        $report = $service->getStockBalance($filterDTO);

        return $report->items;
    }
}
