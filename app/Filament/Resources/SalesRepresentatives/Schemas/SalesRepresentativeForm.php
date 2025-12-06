<?php

namespace App\Filament\Resources\SalesRepresentatives\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;

class SalesRepresentativeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Fieldset::make(__('lang.sales_representative_info'))
                    ->columnSpanFull()
                    ->schema([
                        Grid::make(2)->schema([
                            Select::make('user_id')
                                ->label(__('lang.user'))
                                ->relationship('user', 'name')
                                ->required()
                                ->searchable()
                                ->preload()
                                ->columnSpan(1),

                            TextInput::make('name')
                                ->label(__('lang.name'))
                                ->required()
                                ->maxLength(255)
                                ->columnSpan(1),
                        ]),

                        Grid::make(2)->schema([
                            TextInput::make('email')
                                ->label(__('lang.email'))
                                ->email()
                                ->maxLength(255)
                                ->columnSpan(1),

                            TextInput::make('phone')
                                ->label(__('lang.phone'))
                                ->tel()
                                ->maxLength(255)
                                ->columnSpan(1),
                        ]),

                        Grid::make(2)->schema([
                            TextInput::make('rep_code')
                                ->label(__('lang.rep_code'))
                                ->required()
                                ->unique(ignoreRecord: true)
                                ->maxLength(255)
                                ->columnSpan(1),

                            Select::make('current_vehicle_id')
                                ->label(__('lang.current_vehicle'))
                                ->relationship('currentVehicle', 'plate_number')
                                ->searchable()
                                ->preload()
                                ->columnSpan(1),
                        ]),

                        Grid::make(3)->schema([
                            TextInput::make('cash_wallet')
                                ->label(__('lang.cash_wallet'))
                                ->numeric()
                                ->default(0)
                                ->prefix('$')
                                ->columnSpan(1),

                            TextInput::make('credit_limit_allowance')
                                ->label(__('lang.credit_limit_allowance'))
                                ->numeric()
                                ->default(0)
                                ->prefix('$')
                                ->columnSpan(1),

                            TextInput::make('commission_rate')
                                ->label(__('lang.commission_rate'))
                                ->numeric()
                                ->default(0)
                                ->suffix('%')
                                ->columnSpan(1),
                        ]),

                        Toggle::make('is_active')
                            ->label(__('lang.is_active'))
                            ->required()
                            ->default(true)
                            ->inline(false),
                    ]),
            ]);
    }
}
