<?php

namespace App\Filament\Resources\StockSupplyOrders\Schemas;

use App\Constants;
use App\Models\Product;
use App\Models\ProductUnit;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Wizard;
use Filament\Schemas\Components\Wizard\Step;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

class StockSupplyOrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Wizard::make([
                    // Step 1: Supply Information
                    Step::make(__('lang.supply_info'))
                        ->icon('heroicon-o-document-text')
                        ->schema([
                            Grid::make(3)
                                ->schema([
                                    TextInput::make('supply_number')
                                        ->label(__('lang.supply_number'))
                                        ->default(fn() => 'SUP-' . date('Ymd') . '-' . str_pad(random_int(1, 9999), 4, '0', STR_PAD_LEFT))
                                        ->required()
                                        ->unique(ignoreRecord: true)
                                        ->maxLength(50),

                                    DatePicker::make('supply_date')
                                        ->label(__('lang.supply_date'))
                                        ->default(now())
                                        ->required(),

                                    Select::make('status')
                                        ->label(__('lang.status'))
                                        ->options([
                                            'pending' => __('lang.supply_pending'),
                                            'approved' => __('lang.supply_approved'),
                                            'received' => __('lang.supply_received'),
                                            'cancelled' => __('lang.supply_cancelled'),
                                        ])
                                        ->default('pending')
                                        ->required(),
                                ]),

                            Grid::make(3)
                                ->schema([
                                    Select::make('store_id')
                                        ->label(__('lang.store'))
                                        ->relationship('store', 'name')
                                        ->searchable()
                                        ->preload()
                                        ->required(),

                                    TextInput::make('supplier_name')
                                        ->label(__('lang.supplier_name'))
                                        ->maxLength(255),

                                    TextInput::make('supplier_reference')
                                        ->label(__('lang.supplier_reference'))
                                        ->maxLength(255),
                                ]),

                            Textarea::make('notes')
                                ->label(__('lang.notes'))
                                ->rows(2)
                                ->columnSpanFull(),
                        ]),

                    // Step 2: Supply Items
                    Step::make(__('lang.supply_items'))
                        ->icon('heroicon-o-cube')
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
                                                ->afterStateUpdated(function ($set) {
                                                    // Reset unit and related fields when product changes
                                                    $set('unit_id', null);
                                                    $set('package_size', 1);
                                                    $set('unit_cost', null);
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
                                                        ->pluck('unit.name', 'unit_id');
                                                })
                                                // ->searchable()
                                                ->preload()
                                                ->required()
                                                ->live()
                                                ->afterStateUpdated(function ($set, $state, Get $get) {
                                                    if ($state && $get('product_id')) {
                                                        $productUnit = ProductUnit::where('product_id', $get('product_id'))
                                                            ->where('unit_id', $state)
                                                            ->first();

                                                        if ($productUnit) {
                                                            $set('package_size', $productUnit->package_size ?? 1);
                                                            $set('unit_cost', $productUnit->cost_price);
                                                        }
                                                    }
                                                }),

                                            TextInput::make('quantity')
                                                ->label(__('lang.quantity'))
                                                ->numeric()
                                                ->default(1)
                                                ->minValue(0.0001)
                                                ->required(),

                                            TextInput::make('package_size')
                                                ->label(__('lang.package_size'))
                                                ->numeric()
                                                ->default(1)
                                                ->disabled()
                                                ->dehydrated(),

                                            TextInput::make('unit_cost')
                                                ->label(__('lang.unit_cost'))
                                                ->numeric()
                                                ->prefix(Constants::CURRENCY)
                                                ->disabled()
                                                ->dehydrated(),
                                        ]),
                                ])
                                ->addActionLabel(__('lang.add_item'))
                                ->reorderable(false)
                                ->columns(1),
                        ]),
                ])->skippable()
                    ->columnSpanFull(),
            ]);
    }
}
