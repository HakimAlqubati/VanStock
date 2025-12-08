<?php

namespace App\Filament\Resources\StockTransfers\Schemas;

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

class StockTransferForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Wizard::make([
                    // Step 1: Transfer Information
                    Step::make(__('lang.transfer_info'))
                        ->icon('heroicon-o-document-text')
                        ->schema([
                            Grid::make(3)
                                ->schema([
                                    TextInput::make('transfer_number')
                                        ->label(__('lang.transfer_number'))
                                        ->default(fn() => 'TRF-' . date('Ymd') . '-' . str_pad(random_int(1, 9999), 4, '0', STR_PAD_LEFT))
                                        ->required()
                                        ->unique(ignoreRecord: true)
                                        ->maxLength(50),

                                    DatePicker::make('transfer_date')
                                        ->label(__('lang.transfer_date'))
                                        ->default(now())
                                        ->required(),

                                    Select::make('status')
                                        ->label(__('lang.status'))
                                        ->options([
                                            'pending' => __('lang.transfer_pending'),
                                            'approved' => __('lang.transfer_approved'),
                                            'in_transit' => __('lang.transfer_in_transit'),
                                            'completed' => __('lang.transfer_completed'),
                                            'cancelled' => __('lang.transfer_cancelled'),
                                        ])
                                        ->default('pending')
                                        ->required(),
                                ]),

                            Grid::make(2)
                                ->schema([
                                    Select::make('from_store_id')
                                        ->label(__('lang.from_store'))
                                        ->relationship('fromStore', 'name')
                                        ->searchable()
                                        ->preload()
                                        ->required()
                                        ->different('to_store_id'),

                                    Select::make('to_store_id')
                                        ->label(__('lang.to_store'))
                                        ->relationship('toStore', 'name')
                                        ->searchable()
                                        ->preload()
                                        ->required()
                                        ->different('from_store_id'),
                                ]),

                            Textarea::make('notes')
                                ->label(__('lang.notes'))
                                ->rows(2)
                                ->columnSpanFull(),
                        ]),

                    // Step 2: Transfer Items
                    Step::make(__('lang.transfer_items'))
                        ->icon('heroicon-o-cube')
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
                                                ->afterStateUpdated(function ($set) {
                                                    // Reset unit and related fields when product changes
                                                    $set('unit_id', null);
                                                    $set('package_size', 1);
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
