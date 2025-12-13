<?php

namespace App\Filament\Pages\Reports;

use App\DTOs\Inventory\InventoryFilterDTO;
use App\Services\Inventory\InventoryReportService;
use App\Models\Product;
use App\Models\Category;
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

class StockByProductReport extends Page implements HasTable
{
    use InteractsWithTable;

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-cube';

    protected   string $view = 'filament.pages.reports.stock-by-product-report';

    protected static string | UnitEnum | null $navigationGroup = 'التقارير';

    protected static ?int $navigationSort = 2;

    public ?array $filters = [];

    public static function getNavigationLabel(): string
    {
        return __('lang.stock_by_product_report');
    }

    public function getTitle(): string|Htmlable
    {
        return __('lang.stock_by_product_report');
    }

    public function getHeading(): string|Htmlable
    {
        return __('lang.stock_by_product_report');
    }

    public function getSubheading(): string|Htmlable|null
    {
        return __('lang.stock_by_product_report_desc');
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('lang.filters'))
                    ->schema([
                        Select::make('filters.product_id')
                            ->label(__('lang.product'))
                            ->options(Product::pluck('name', 'id'))
                            ->searchable()
                            ->preload()
                            ->placeholder(__('lang.all_products')),

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
                    ->columns(4)
                    ->collapsible(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->records(fn() => $this->getReportQuery())
            ->columns([
                TextColumn::make('productName')
                    ->label(__('lang.product'))
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('categoryName')
                    ->label(__('lang.category'))
                    ->searchable()
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
                    ->color(fn($state) => $state > 0 ? 'success' : ($state < 0 ? 'danger' : 'gray'))
                    ->alignEnd(),

                TextColumn::make('unitName')
                    ->label(__('lang.unit'))
                    ->badge()
                    ->color('primary'),
            ])
            ->defaultSort('productName')
            ->striped()
            ->paginated([10, 25, 50, 100]);
    }

    protected function getReportQuery()
    {
        $service = app(InventoryReportService::class);
        $filterDTO = InventoryFilterDTO::fromArray($this->filters['filters'] ?? []);
        $report = $service->getStockByProduct($filterDTO);

        return $report->items->map(fn($item) => $item->toArray())->toArray();
    }

    public function getReportSummary(): array
    {
        $service = app(InventoryReportService::class);
        $filterDTO = InventoryFilterDTO::fromArray($this->filters['filters'] ?? []);
        $report = $service->getStockByProduct($filterDTO);

        return [
            'total_in' => $report->totalQuantityIn,
            'total_out' => $report->totalQuantityOut,
            'total_balance' => $report->totalBalance,
            'items_count' => $report->count(),
        ];
    }

    public function getReportData()
    {
        $service = app(InventoryReportService::class);
        $filterDTO = InventoryFilterDTO::fromArray($this->filters['filters'] ?? []);
        $report = $service->getStockByProduct($filterDTO);

        return $report->items;
    }
}
