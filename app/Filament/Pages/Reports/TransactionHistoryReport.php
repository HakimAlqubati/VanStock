<?php

namespace App\Filament\Pages\Reports;

use App\DTOs\Inventory\InventoryFilterDTO;
use App\Services\Inventory\InventoryReportService;
use App\Models\Product;
use App\Models\Store;
use App\Models\Category;
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

class TransactionHistoryReport extends Page implements HasTable
{
    use InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-clock';

    protected static string $view = 'filament.pages.reports.transaction-history-report';

    protected static ?string $navigationGroup = 'التقارير';

    protected static ?int $navigationSort = 5;

    public ?array $filters = [];

    public static function getNavigationLabel(): string
    {
        return __('lang.transaction_history_report');
    }

    public function getTitle(): string|Htmlable
    {
        return __('lang.transaction_history_report');
    }

    public function getHeading(): string|Htmlable
    {
        return __('lang.transaction_history_report');
    }

    public function getSubheading(): string|Htmlable|null
    {
        return __('lang.transaction_history_report_desc');
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

                        Select::make('filters.movement_type')
                            ->label(__('lang.movement_type'))
                            ->options([
                                'in' => __('lang.movement_in'),
                                'out' => __('lang.movement_out'),
                            ])
                            ->placeholder(__('lang.all_movements')),

                        DatePicker::make('filters.date_from')
                            ->label(__('lang.date_from'))
                            ->native(false),

                        DatePicker::make('filters.date_to')
                            ->label(__('lang.date_to'))
                            ->native(false),
                    ])
                    ->columns(6)
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
                    ->weight('bold'),

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
                    ->alignEnd()
                    ->placeholder('-'),

                TextColumn::make('quantityOut')
                    ->label(__('lang.quantity_out'))
                    ->numeric(decimalPlaces: 2)
                    ->sortable()
                    ->color('danger')
                    ->alignEnd()
                    ->placeholder('-'),

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
        $report = $service->getTransactionHistory($filterDTO);

        return collect($report->items->map(fn($item) => (object) $item->toArray()));
    }

    public function getReportSummary(): array
    {
        $service = app(InventoryReportService::class);
        $filterDTO = InventoryFilterDTO::fromArray($this->filters['filters'] ?? []);
        $report = $service->getTransactionHistory($filterDTO);

        return [
            'total_in' => $report->totalQuantityIn,
            'total_out' => $report->totalQuantityOut,
            'transactions_count' => $report->count(),
        ];
    }
}
