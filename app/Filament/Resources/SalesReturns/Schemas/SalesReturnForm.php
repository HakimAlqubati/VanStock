<?php

namespace App\Filament\Resources\SalesReturns\Schemas;

use App\Constants;
use App\Models\Product;
use App\Models\ProductUnit;
use App\Models\SalesInvoice;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Components\Wizard;
use Filament\Schemas\Schema;

class SalesReturnForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Wizard::make([
                    // Step 1: Return Info
                    Wizard\Step::make(__('lang.return_info'))
                        ->icon('heroicon-o-arrow-uturn-left')
                        ->schema([
                            Grid::make(3)
                                ->schema([
                                    TextInput::make('return_number')
                                        ->label(__('lang.return_number'))
                                        ->default(fn() => 'RET-' . date('Ymd') . '-' . str_pad(random_int(1, 9999), 4, '0', STR_PAD_LEFT))
                                        ->required()
                                        ->unique(ignoreRecord: true)
                                        ->maxLength(50),

                                    DatePicker::make('return_date')
                                        ->label(__('lang.return_date'))
                                        ->default(now())
                                        ->required(),

                                    Select::make('status')
                                        ->label(__('lang.status'))
                                        ->options([
                                            'pending' => __('lang.return_pending'),
                                            'approved' => __('lang.return_approved'),
                                            'rejected' => __('lang.return_rejected'),
                                        ])
                                        ->default('pending')
                                        ->required(),
                                ]),

                            Grid::make(2)
                                ->schema([
                                    Select::make('sales_invoice_id')
                                        ->label(__('lang.from_invoice'))
                                        ->relationship('salesInvoice', 'invoice_number')
                                        ->searchable()
                                        ->preload()
                                        ->live()
                                        ->afterStateUpdated(function (Set $set, ?int $state) {
                                            if ($state) {
                                                $invoice = SalesInvoice::with(['customer', 'salesRepresentative', 'store'])->find($state);
                                                if ($invoice) {
                                                    $set('customer_id', $invoice->customer_id);
                                                    $set('sales_representative_id', $invoice->sales_representative_id);
                                                    $set('store_id', $invoice->store_id);
                                                }
                                            }
                                        }),

                                    Select::make('customer_id')
                                        ->label(__('lang.customer'))
                                        ->relationship('customer', 'name')
                                        ->searchable()
                                        ->preload()
                                        ->required(),
                                ]),

                            Grid::make(2)
                                ->schema([
                                    Select::make('sales_representative_id')
                                        ->label(__('lang.sale_representative'))
                                        ->relationship('salesRepresentative.user', 'name')
                                        ->searchable()
                                        ->preload()
                                        ->required(),

                                    Select::make('store_id')
                                        ->label(__('lang.store'))
                                        ->relationship('store', 'name')
                                        ->searchable()
                                        ->preload()
                                        ->required(),
                                ]),

                            Textarea::make('reason')
                                ->label(__('lang.reason'))
                                ->rows(3)
                                ->columnSpanFull(),
                        ]),

                    // Step 2: Return Items
                    Wizard\Step::make(__('lang.return_items'))
                        ->icon('heroicon-o-shopping-cart')
                        ->schema([
                            Repeater::make('items')
                                ->relationship()
                                ->schema([
                                    Grid::make(5)
                                        ->schema([
                                            Select::make('product_id')
                                                ->label(__('lang.product'))
                                                ->relationship('product', 'name')
                                                ->searchable()
                                                ->preload()
                                                ->required()
                                                ->live()
                                                ->afterStateUpdated(function (Set $set, ?int $state) {
                                                    // Reset fields when product changes
                                                    $set('unit_id', null);
                                                    $set('unit_price', null);
                                                    $set('package_size', 1);
                                                    $set('total', null);

                                                    if ($state) {
                                                        $product = Product::find($state);
                                                        if ($product) {
                                                            $defaultUnit = $product->productUnits()->where('is_default', true)->first();
                                                            if ($defaultUnit) {
                                                                $set('unit_id', $defaultUnit->unit_id);
                                                                $set('unit_price', $defaultUnit->selling_price);
                                                                $set('package_size', $defaultUnit->package_size ?? 1);
                                                            }
                                                        }
                                                    }
                                                })
                                                ->columnSpan(2),

                                            Select::make('unit_id')
                                                ->label(__('lang.unit'))
                                                ->options(function (Get $get) {
                                                    $productId = $get('product_id');
                                                    if (!$productId) {
                                                        return [];
                                                    }
                                                    return ProductUnit::where('product_id', $productId)
                                                        ->with('unit')
                                                        ->get()
                                                        ->pluck('unit.name', 'unit_id')
                                                        ->toArray();
                                                })
                                                ->searchable()
                                                ->preload()
                                                ->required()
                                                ->live()
                                                ->afterStateUpdated(function (Get $get, Set $set, ?int $state) {
                                                    if ($state && $get('product_id')) {
                                                        $productUnit = ProductUnit::where('product_id', $get('product_id'))
                                                            ->where('unit_id', $state)
                                                            ->first();
                                                        if ($productUnit) {
                                                            $set('unit_price', $productUnit->selling_price);
                                                            $set('package_size', $productUnit->package_size ?? 1);
                                                            self::calculateItemTotal($get, $set);
                                                        }
                                                    }
                                                }),

                                            TextInput::make('quantity')
                                                ->label(__('lang.quantity'))
                                                ->numeric()
                                                ->default(1)
                                                ->minValue(0.0001)
                                                ->required()
                                                ->live()
                                                ->afterStateUpdated(fn(Get $get, Set $set) => self::calculateItemTotal($get, $set)),

                                            TextInput::make('unit_price')
                                                ->label(__('lang.unit_price'))
                                                ->numeric()
                                                ->required()
                                                ->live()
                                                ->afterStateUpdated(fn(Get $get, Set $set) => self::calculateItemTotal($get, $set)),

                                            TextInput::make('total')
                                                ->label(__('lang.total'))
                                                ->numeric()
                                                ->disabled()
                                                ->dehydrated(),

                                            Hidden::make('package_size')
                                                ->default(1),
                                        ]),
                                ])
                                ->addActionLabel(__('lang.add_item'))
                                ->reorderable(false)
                                ->columns(1),
                        ]),

                    // Step 3: Financial Info
                    Wizard\Step::make(__('lang.financial_info'))
                        ->icon('heroicon-o-banknotes')
                        ->schema([
                            TextInput::make('total_amount')
                                ->label(__('lang.total_amount'))
                                ->numeric()
                                ->default(0)
                                ->prefix(Constants::CURRENCY)
                                ->disabled()
                                ->dehydrated(),
                        ]),
                ])
                    ->skippable()
                    ->columnSpanFull(),
            ]);
    }

    protected static function calculateItemTotal(Get $get, Set $set): void
    {
        $quantity = floatval($get('quantity') ?? 0);
        $unitPrice = floatval($get('unit_price') ?? 0);

        $total = $quantity * $unitPrice;
        $set('total', round($total, 2));
    }
}
