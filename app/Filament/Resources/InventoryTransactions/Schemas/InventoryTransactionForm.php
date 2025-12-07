<?php

namespace App\Filament\Resources\InventoryTransactions\Schemas;

use App\Constants;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class InventoryTransactionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('lang.transaction_info'))
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                Select::make('movement_type')
                                    ->label(__('lang.movement_type'))
                                    ->options([
                                        'in' => __('lang.movement_in'),
                                        'out' => __('lang.movement_out'),
                                    ])
                                    ->required(),

                                DatePicker::make('movement_date')
                                    ->label(__('lang.movement_date'))
                                    ->default(now())
                                    ->required(),

                                DatePicker::make('transaction_date')
                                    ->label(__('lang.transaction_date'))
                                    ->default(now()),
                            ]),

                        Grid::make(3)
                            ->schema([
                                Select::make('product_id')
                                    ->label(__('lang.product'))
                                    ->relationship('product', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->required(),

                                Select::make('store_id')
                                    ->label(__('lang.store'))
                                    ->relationship('store', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->required(),

                                Select::make('unit_id')
                                    ->label(__('lang.unit'))
                                    ->relationship('unit', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->required(),
                            ]),

                        Grid::make(3)
                            ->schema([
                                TextInput::make('quantity')
                                    ->label(__('lang.quantity'))
                                    ->numeric()
                                    ->required()
                                    ->minValue(0.0001),

                                TextInput::make('package_size')
                                    ->label(__('lang.package_size'))
                                    ->numeric()
                                    ->default(1),

                                TextInput::make('price')
                                    ->label(__('lang.unit_price'))
                                    ->numeric()
                                    ->prefix(Constants::CURRENCY),
                            ]),
                    ]),

                Section::make(__('lang.basic_info'))
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                Select::make('base_unit_id')
                                    ->label(__('lang.base_unit'))
                                    ->relationship('baseUnit', 'name')
                                    ->searchable()
                                    ->preload(),

                                TextInput::make('base_quantity')
                                    ->label(__('lang.base_quantity'))
                                    ->numeric(),

                                TextInput::make('base_unit_package_size')
                                    ->label(__('lang.package_size'))
                                    ->numeric(),
                            ]),

                        Grid::make(3)
                            ->schema([
                                TextInput::make('remaining_quantity')
                                    ->label(__('lang.remaining_quantity'))
                                    ->numeric()
                                    ->disabled()
                                    ->dehydrated(),

                                TextInput::make('price_per_base_unit')
                                    ->label(__('lang.price_per_base_unit'))
                                    ->numeric()
                                    ->prefix(Constants::CURRENCY),

                                TextInput::make('waste_stock_percentage')
                                    ->label(__('lang.waste_stock_percentage'))
                                    ->numeric()
                                    ->suffix('%'),
                            ]),

                        Textarea::make('notes')
                            ->label(__('lang.notes'))
                            ->rows(3)
                            ->columnSpanFull(),
                    ])
                    ->collapsible(),
            ]);
    }
}
