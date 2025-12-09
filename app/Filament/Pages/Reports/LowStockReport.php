<?php

namespace App\Filament\Pages\Reports;

use App\DTOs\Inventory\InventoryFilterDTO;
use App\Services\Inventory\InventoryReportService;
use App\Models\Store;
use App\Models\Category;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;

class LowStockReport extends Page implements HasTable
{
    use InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-exclamation-triangle';

    protected static string $view = 'filament.pages.reports.low-stock-report';

    protected static ?string $navigationGroup = 'التقارير';

    protected static ?int $navigationSort = 6;

    public ?array $filters = [];
    public int $threshold = 10;

    public static function getNavigationLabel(): string
    {
        return __('lang.low_stock_report');
    }

    public function getTitle(): string|Htmlable
    {
        return __('lang.low_stock_report');
    }

    public function getHeading(): string|Htmlable
    {
        return __('lang.low_stock_report');
    }

    public function getSubheading(): string|Htmlable|null
    {
        return __('lang.low_stock_report_desc');
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('lang.filters'))
                    ->schema([
                        TextInput::make('threshold')
                            ->label(__('lang.stock_threshold'))
                            ->numeric()
                            ->default(10)
                            ->minValue(0)
                            ->step(1)
                            ->helperText(__('lang.stock_threshold_help')),

                        Select::make('filters.store_id')
                            ->label(__('lang.store'))
                            ->options(Store::pluck('name', 'id'))
                            ->searchable()
                            ->preload()
                            ->placeholder(__('lang.all_stores')),

                        Select::make('filters.category_id')
                            ->label(__('lang.category'))
                            ->options(Category::pluck('name', 'id'))
                            ->searchable()
                            ->preload()
                            ->placeholder(__('lang.all_categories')),

                        DatePicker::make('filters.date_from')
                            ->label(__('lang.date_from'))
                            ->native(false),

                        DatePicker::make('filters.date_to')
                            ->label(__('lang.date_to'))
                            ->native(false),
                    ])
                    ->columns(5)
                    ->collapsible(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(fn() => $this->getReportQuery())
            ->columns([
                TextColumn::make('productName')
                    ->label(__('lang.product'))
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->icon('heroicon-o-exclamation-triangle')
                    ->iconColor('warning'),

                TextColumn::make('storeName')
                    ->label(__('lang.store'))
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('info'),

                TextColumn::make('categoryName')
                    ->label(__('lang.category'))
                    ->sortable()
                    ->badge()
                    ->color('gray'),

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
                    ->color(fn($state) => $state <= 0 ? 'danger' : 'warning')
                    ->alignEnd(),

                TextColumn::make('unitName')
                    ->label(__('lang.unit'))
                    ->badge()
                    ->color('primary'),
            ])
            ->defaultSort('balance', 'asc')
            ->striped()
            ->paginated([10, 25, 50, 100]);
    }

    protected function getReportQuery()
    {
        $service = app(InventoryReportService::class);
        $filterDTO = InventoryFilterDTO::fromArray($this->filters['filters'] ?? []);
        $threshold = (int) ($this->filters['threshold'] ?? $this->threshold);
        $report = $service->getLowStockItems($threshold, $filterDTO);

        return collect($report->items->map(fn($item) => (object) $item->toArray()));
    }

    public function getReportSummary(): array
    {
        $service = app(InventoryReportService::class);
        $filterDTO = InventoryFilterDTO::fromArray($this->filters['filters'] ?? []);
        $threshold = (int) ($this->filters['threshold'] ?? $this->threshold);
        $report = $service->getLowStockItems($threshold, $filterDTO);

        $outOfStock = $report->items->filter(fn($item) => $item->balance <= 0)->count();
        $lowStock = $report->items->filter(fn($item) => $item->balance > 0)->count();

        return [
            'out_of_stock' => $outOfStock,
            'low_stock' => $lowStock,
            'total_items' => $report->count(),
            'threshold' => $threshold,
        ];
    }
}
