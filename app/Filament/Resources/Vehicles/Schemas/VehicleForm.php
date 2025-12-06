<?php

namespace App\Filament\Resources\Vehicles\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Schema;

class VehicleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Fieldset::make()->columnSpanFull()->schema([
                    Select::make('store_id')
                        ->relationship('store', 'name')
                        ->searchable()
                        ->preload()
                        ->required(),
                    TextInput::make('plate_number')
                        ->required()
                        ->maxLength(255),
                    TextInput::make('model')
                        ->required()
                        ->maxLength(255),
                    TextInput::make('chassis_number')
                        ->maxLength(255),
                    TextInput::make('status')
                        ->required()
                        ->maxLength(255)
                        ->default('active'),
                    TextInput::make('max_load_capacity_kg')
                        ->numeric()
                        ->label('Max Load Capacity (KG)'),
                    DatePicker::make('license_expiry_date'),
                    DatePicker::make('insurance_expiry_date'),
                ])
            ]);
    }
}
