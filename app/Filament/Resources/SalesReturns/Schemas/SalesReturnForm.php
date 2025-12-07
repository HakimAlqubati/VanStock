<?php

namespace App\Filament\Resources\SalesReturns\Schemas;

use App\Constants;
use App\Models\Product;
use App\Models\SalesInvoice;
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

class SalesReturnForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('lang.return_info'))
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

                Section::make(__('lang.return_items'))
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
                        TextInput::make('total_amount')
                            ->label(__('lang.total_amount'))
                            ->numeric()
                            ->default(0)
                            ->prefix(Constants::CURRENCY)
                            ->disabled()
                            ->dehydrated(),
                    ]),
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
