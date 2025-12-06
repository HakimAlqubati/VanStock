<?php

namespace App\Filament\Resources\SalesRepresentatives\Schemas;

use Filament\Schemas\Schema;

class SalesRepresentativeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Schemas\Components\Section::make()->columnSpanFull()
                    ->schema([
                        \Filament\Forms\Components\Select::make('user_id')
                            ->relationship('user', 'name')
                            ->required()
                            ->searchable()
                            ->preload(),
                        \Filament\Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        \Filament\Forms\Components\TextInput::make('email')
                            ->email()
                            ->maxLength(255),
                        \Filament\Forms\Components\TextInput::make('phone')
                            ->tel()
                            ->maxLength(255),
                        \Filament\Forms\Components\Select::make('current_vehicle_id')
                            ->relationship('currentVehicle', 'plate_number')
                            ->searchable()
                            ->preload(),
                        \Filament\Forms\Components\TextInput::make('rep_code')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                        \Filament\Forms\Components\TextInput::make('cash_wallet')
                            ->numeric()
                            ->default(0)
                            ->prefix('$'),
                        \Filament\Forms\Components\TextInput::make('credit_limit_allowance')
                            ->numeric()
                            ->default(0)
                            ->prefix('$'),
                        \Filament\Forms\Components\TextInput::make('commission_rate')
                            ->numeric()
                            ->default(0)
                            ->suffix('%'),
                        \Filament\Forms\Components\Toggle::make('is_active')
                            ->required()
                            ->default(true),
                    ])->columns(2),
            ]);
    }
}
