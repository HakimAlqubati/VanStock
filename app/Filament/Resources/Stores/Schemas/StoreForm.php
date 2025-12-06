<?php

namespace App\Filament\Resources\Stores\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;

class StoreForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Fieldset::make(__('lang.store_information'))
                    ->columnSpanFull()
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('name')
                                ->label(__('lang.name'))
                                ->required()
                                ->maxLength(255)
                                ->columnSpan(1),

                            TextInput::make('location')
                                ->label(__('lang.location'))
                                ->maxLength(255)
                                ->columnSpan(1),
                        ]),

                        Grid::make(3)->schema([
                            Select::make('storekeeper_id')
                                ->label(__('lang.storekeeper'))
                                ->relationship('storekeeper', 'name')
                                ->searchable()
                                ->preload()
                                ->nullable()
                                ->columnSpan(1),

                            Toggle::make('active')
                                ->label(__('lang.active'))
                                ->default(true)
                                ->inline(false)
                                ->columnSpan(1),

                            Toggle::make('default_store')
                                ->label(__('lang.default_store'))
                                ->default(false)
                                ->inline(false)
                                ->columnSpan(1),
                        ]),
                    ]),
            ]);
    }
}
