<?php

namespace App\Filament\Resources\StockIssueOrders\Schemas;

use App\Models\Product;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Set;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class StockIssueOrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('lang.issue_info'))
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextInput::make('issue_number')
                                    ->label(__('lang.issue_number'))
                                    ->default(fn() => 'ISS-' . date('Ymd') . '-' . str_pad(random_int(1, 9999), 4, '0', STR_PAD_LEFT))
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->maxLength(50),

                                DatePicker::make('issue_date')
                                    ->label(__('lang.issue_date'))
                                    ->default(now())
                                    ->required(),

                                Select::make('status')
                                    ->label(__('lang.status'))
                                    ->options([
                                        'pending' => __('lang.issue_pending'),
                                        'approved' => __('lang.issue_approved'),
                                        'issued' => __('lang.issue_issued'),
                                        'cancelled' => __('lang.issue_cancelled'),
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

                                TextInput::make('recipient_name')
                                    ->label(__('lang.recipient_name'))
                                    ->maxLength(255),

                                TextInput::make('recipient_department')
                                    ->label(__('lang.recipient_department'))
                                    ->maxLength(255),
                            ]),

                        Textarea::make('notes')
                            ->label(__('lang.notes'))
                            ->rows(2)
                            ->columnSpanFull(),
                    ]),

                Section::make(__('lang.issue_items'))
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
                                            ->required(),

                                        TextInput::make('package_size')
                                            ->label(__('lang.package_size'))
                                            ->numeric()
                                            ->default(1),
                                    ]),
                            ])
                            ->addActionLabel(__('lang.add_item'))
                            ->reorderable(false)
                            ->columns(1),
                    ]),
            ]);
    }
}
