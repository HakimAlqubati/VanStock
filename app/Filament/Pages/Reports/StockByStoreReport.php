<?php

namespace App\Filament\Pages\Reports;

use App\DTOs\Inventory\InventoryFilterDTO;
use App\Services\Inventory\InventoryReportService;
use App\Models\Store;
use BackedEnum;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;
use UnitEnum;

class StockByStoreReport extends Page implements HasTable
{
    use InteractsWithTable;

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-building-storefront';

    protected   string $view = 'filament.pages.reports.stock-by-store-report';

    protected static string | UnitEnum | null $navigationGroup = 'التقارير';

    protected static ?int $navigationSort = 3;

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
            ->components([
                Section::make(__('lang.filters'))
                    ->schema([
                        Select::make('filters.store_id')
                            ->label(__('lang.store'))
                            ->options(Store::pluck('name', 'id'))
                            ->searchable()
                            ->preload()
                            ->placeholder(__('lang.all_stores')),

                        DatePicker::make('filters.date_from')
                            ->label(__('lang.date_from'))
                            ->native(false),

                        DatePicker::make('filters.date_to')
                            ->label(__('lang.date_to'))
                            ->native(false),
                    ])
                    ->columns(3)
                    ->collapsible(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->records(fn() => $this->getReportQuery())
            ->columns([
                TextColumn::make('storeName')
                    ->label(__('lang.store'))
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->icon('heroicon-o-building-storefront'),

                TextColumn::make('productName')
                    ->label(__('lang.products_count'))
                    ->badge()
                    ->color('info'),

                TextColumn::make('quantityIn')
                    ->label(__('lang.quantity_in'))
                    ->numeric(decimalPlaces: 2)
                    ->sortable()
                    ->color('success')
                    ->alignEnd(),

                TextColumn::make('quantityOut')
                    ->label(__('lang.quantity_out'))
                    ->numeric(decimalPlaces: 2)
                    ->sortable()
                    ->color('danger')
                    ->alignEnd(),

                TextColumn::make('balance')
                    ->label(__('lang.balance'))
                    ->numeric(decimalPlaces: 2)
                    ->sortable()
                    ->weight('bold')
                    ->color(fn($state) => $state > 0 ? 'success' : ($state < 0 ? 'danger' : 'gray'))
                    ->alignEnd(),
            ])
            ->defaultSort('storeName')
            ->striped()
            ->paginated([10, 25, 50, 100]);
    }

    protected function getReportQuery()
    {
        $service = app(InventoryReportService::class);
        $filterDTO = InventoryFilterDTO::fromArray($this->filters['filters'] ?? []);
        $report = $service->getStockByStore($filterDTO);

        return $report->items->map(fn($item) => $item->toArray())->toArray();
    }

    public function getReportSummary(): array
    {
        $service = app(InventoryReportService::class);
        $filterDTO = InventoryFilterDTO::fromArray($this->filters['filters'] ?? []);
        $report = $service->getStockByStore($filterDTO);

        return [
            'total_in' => $report->totalQuantityIn,
            'total_out' => $report->totalQuantityOut,
            'total_balance' => $report->totalBalance,
            'stores_count' => $report->count(),
        ];
    }
}
