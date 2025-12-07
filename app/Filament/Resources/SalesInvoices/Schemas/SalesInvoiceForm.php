<?php

namespace App\Filament\Resources\SalesInvoices\Schemas;

use App\Constants;
use App\Models\Product;
use App\Models\SalesOrder;
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

class SalesInvoiceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('lang.invoice_info'))
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextInput::make('invoice_number')
                                    ->label(__('lang.invoice_number'))
                                    ->default(fn() => 'INV-' . date('Ymd') . '-' . str_pad(random_int(1, 9999), 4, '0', STR_PAD_LEFT))
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->maxLength(50),

                                DatePicker::make('invoice_date')
                                    ->label(__('lang.invoice_date'))
                                    ->default(now())
                                    ->required(),

                                DatePicker::make('due_date')
                                    ->label(__('lang.due_date')),
                            ]),

                        Grid::make(2)
                            ->schema([
                                Select::make('sales_order_id')
                                    ->label(__('lang.from_order'))
                                    ->relationship('salesOrder', 'order_number')
                                    ->searchable()
                                    ->preload()
                                    ->live()
                                    ->afterStateUpdated(function (Set $set, ?int $state) {
                                        if ($state) {
                                            $order = SalesOrder::with(['customer', 'salesRepresentative', 'store', 'items'])->find($state);
                                            if ($order) {
                                                $set('customer_id', $order->customer_id);
                                                $set('sales_representative_id', $order->sales_representative_id);
                                                $set('store_id', $order->store_id);
                                                $set('subtotal', $order->subtotal);
                                                $set('discount_amount', $order->discount_amount);
                                                $set('tax_amount', $order->tax_amount);
                                                $set('total_amount', $order->total_amount);
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

                        Select::make('payment_status')
                            ->label(__('lang.payment_status'))
                            ->options([
                                'unpaid' => __('lang.unpaid'),
                                'partial' => __('lang.partial'),
                                'paid' => __('lang.paid'),
                                'overdue' => __('lang.overdue'),
                            ])
                            ->default('unpaid')
                            ->required(),
                    ]),

                Section::make(__('lang.invoice_items'))
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

                        Grid::make(2)
                            ->schema([
                                TextInput::make('paid_amount')
                                    ->label(__('lang.paid_amount'))
                                    ->numeric()
                                    ->default(0)
                                    ->prefix(Constants::CURRENCY),

                                TextInput::make('remaining_amount')
                                    ->label(__('lang.remaining_amount'))
                                    ->numeric()
                                    ->prefix(Constants::CURRENCY)
                                    ->disabled()
                                    ->dehydrated(false)
                                    ->formatStateUsing(fn(Get $get) => floatval($get('total_amount') ?? 0) - floatval($get('paid_amount') ?? 0)),
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
