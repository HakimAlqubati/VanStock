<?php

namespace App\Filament\Resources\Customers\Schemas;

use App\Constants;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;

class CustomerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('lang.customer_information'))
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('name')
                                    ->label(__('lang.name'))
                                    ->required()
                                    ->maxLength(255),

                                Select::make('customer_type')
                                    ->label(__('lang.customer_type'))
                                    ->options([
                                        'retail' => __('lang.retail'),
                                        'wholesale' => __('lang.wholesale'),
                                    ])
                                    ->default('retail')
                                    ->required(),
                            ]),

                        Toggle::make('active')
                            ->label(__('lang.is_active'))
                            ->default(true),
                    ]),

                Section::make(__('lang.contact_info'))
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('phone')
                                    ->label(__('lang.phone'))
                                    ->tel()
                                    ->maxLength(20),

                                TextInput::make('email')
                                    ->label(__('lang.email'))
                                    ->email()
                                    ->maxLength(255),

                                TextInput::make('contact_person')
                                    ->label(__('lang.contact_person'))
                                    ->maxLength(255),
                            ]),
                    ]),

                Section::make(__('lang.location_info'))
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Select::make('district_id')
                                    ->label(__('lang.district'))
                                    ->relationship('district', 'name')
                                    ->searchable()
                                    ->preload(),

                                Textarea::make('address')
                                    ->label(__('lang.address'))
                                    ->rows(2)
                                    ->columnSpanFull(),
                            ]),

                        Grid::make(2)
                            ->schema([
                                TextInput::make('latitude')
                                    ->label(__('lang.latitude'))
                                    ->numeric()
                                    ->step(0.00000001),

                                TextInput::make('longitude')
                                    ->label(__('lang.longitude'))
                                    ->numeric()
                                    ->step(0.00000001),
                            ]),
                    ]),

                Section::make(__('lang.financial_info'))
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('credit_limit')
                                    ->label(__('lang.credit_limit'))
                                    ->numeric()
                                    ->default(0)
                                    ->prefix(Constants::CURRENCY),

                                TextInput::make('balance')
                                    ->label(__('lang.balance'))
                                    ->numeric()
                                    ->default(0)
                                    ->prefix(Constants::CURRENCY)
                                    ->disabled()
                                    ->dehydrated(false),
                            ]),
                    ]),
            ]);
    }
}
