<?php

namespace App\Filament\Resources\SalesOrders\Schemas;

use App\Constants;
use App\Models\Product;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SalesOrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('lang.order_info'))
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextInput::make('order_number')
                                    ->label(__('lang.order_number'))
                                    ->default(fn() => 'SO-' . date('Ymd') . '-' . str_pad(random_int(1, 9999), 4, '0', STR_PAD_LEFT))
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->maxLength(50),

                                DatePicker::make('order_date')
                                    ->label(__('lang.order_date'))
                                    ->default(now())
                                    ->required(),

                                DatePicker::make('delivery_date')
                                    ->label(__('lang.delivery_date')),
                            ]),

                        Grid::make(3)
                            ->schema([
                                Select::make('customer_id')
                                    ->label(__('lang.customer'))
                                    ->relationship('customer', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->required(),

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

                        Select::make('status')
                            ->label(__('lang.status'))
                            ->options([
                                'pending' => __('lang.pending'),
                                'confirmed' => __('lang.confirmed'),
                                'processing' => __('lang.processing'),
                                'shipped' => __('lang.shipped'),
                                'delivered' => __('lang.delivered'),
                                'cancelled' => __('lang.cancelled'),
                            ])
                            ->default('pending')
                            ->required(),
                    ]),

                Section::make(__('lang.order_items'))
                    ->schema([
                        Repeater::make('items')
                            ->relationship()
                            ->schema([
                                Grid::make(6)
                                    ->schema([
                                        Select::make('product_id')
                                            ->label(__('lang.product'))
                                            ->relationship('product', 'name')
                                            ->searchable()
                                            ->preload()
                                            ->required()
                                            ->live()
                                            ->afterStateUpdated(function (Set $set, ?int $state) {
                                                if ($state) {
                                                    $product = Product::find($state);
                                                    if ($product && $product->productUnits()->where('is_default', true)->first()) {
                                                        $defaultUnit = $product->productUnits()->where('is_default', true)->first();
                                                        $set('unit_id', $defaultUnit->unit_id);
                                                        $set('unit_price', $defaultUnit->selling_price);
                                                    }
                                                }
                                            })
                                            ->columnSpan(2),

                                        Select::make('unit_id')
                                            ->label(__('lang.unit'))
                                            ->relationship('unit', 'name')
                                            ->searchable()
                                            ->preload()
                                            ->required(),

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

                                        TextInput::make('discount')
                                            ->label(__('lang.discount'))
                                            ->numeric()
                                            ->default(0)
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

                Section::make(__('lang.financial_info'))
                    ->schema([
                        Grid::make(4)
                            ->schema([
                                TextInput::make('subtotal')
                                    ->label(__('lang.subtotal'))
                                    ->numeric()
                                    ->default(0)
                                    ->prefix(Constants::CURRENCY)
                                    ->disabled()
                                    ->dehydrated(),

                                TextInput::make('discount_amount')
                                    ->label(__('lang.discount_amount'))
                                    ->numeric()
                                    ->default(0)
                                    ->prefix(Constants::CURRENCY),

                                TextInput::make('tax_amount')
                                    ->label(__('lang.tax_amount'))
                                    ->numeric()
                                    ->default(0)
                                    ->prefix(Constants::CURRENCY),

                                TextInput::make('total_amount')
                                    ->label(__('lang.total_amount'))
                                    ->numeric()
                                    ->default(0)
                                    ->prefix(Constants::CURRENCY)
                                    ->disabled()
                                    ->dehydrated(),
                            ]),

                        Textarea::make('notes')
                            ->label(__('lang.notes'))
                            ->rows(3)
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    protected static function calculateItemTotal(Get $get, Set $set): void
    {
        $quantity = floatval($get('quantity') ?? 0);
        $unitPrice = floatval($get('unit_price') ?? 0);
        $discount = floatval($get('discount') ?? 0);

        $total = ($quantity * $unitPrice) - $discount;
        $set('total', round($total, 2));
    }
}
