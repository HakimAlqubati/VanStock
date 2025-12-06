<?php

namespace App\Filament\Resources\Vehicles\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;

class VehicleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Fieldset::make(__('lang.vehicle_information'))
                    ->columnSpanFull()
                    ->schema([
                        Grid::make(2)->schema([
                            Select::make('store_id')
                                ->label(__('lang.store'))
                                ->relationship('store', 'name')
                                ->searchable()
                                ->preload()
                                ->required()
                                ->columnSpan(1),

                            TextInput::make('plate_number')
                                ->label(__('lang.plate_number'))
                                ->required()
                                ->maxLength(255)
                                ->columnSpan(1),
                        ]),

                        Grid::make(2)->schema([
                            TextInput::make('model')
                                ->label(__('lang.model'))
                                ->required()
                                ->maxLength(255)
                                ->columnSpan(1),

                            TextInput::make('chassis_number')
                                ->label(__('lang.chassis_number'))
                                ->maxLength(255)
                                ->columnSpan(1),
                        ]),

                        Grid::make(3)->schema([
                            Select::make('status')
                                ->label(__('lang.status'))
                                ->options([
                                    'active' => __('lang.active'),
                                    'maintenance' => __('lang.maintenance'),
                                    'inactive' => __('lang.inactive'),
                                ])
                                ->default('active')
                                ->required()
                                ->columnSpan(1),

                            TextInput::make('max_load_capacity_kg')
                                ->label(__('lang.max_load_capacity_kg'))
                                ->numeric()
                                ->columnSpan(1),
                        ]),

                        Grid::make(2)->schema([
                            DatePicker::make('license_expiry_date')
                                ->label(__('lang.license_expiry_date'))
                                ->columnSpan(1),

                            DatePicker::make('insurance_expiry_date')
                                ->label(__('lang.insurance_expiry_date'))
                                ->columnSpan(1),
                        ]),
                    ]),
            ]);
    }
}
