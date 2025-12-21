<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Hash;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Fieldset::make(__('lang.user_info'))->columnSpanFull()->columns(2)->schema([
                    TextInput::make('name')
                        ->label(__('lang.name'))
                        ->required()
                        ->maxLength(255),
                    TextInput::make('email')
                        ->label(__('lang.email'))
                        ->required()
                        ->maxLength(255),
                    TextInput::make('password')
                        ->label(__('lang.password'))
                        ->password()
                        ->required(fn(string $context): bool => $context === 'create')
                        ->dehydrateStateUsing(fn($state) => Hash::make($state))
                        ->dehydrated(fn($state) => filled($state))
                        ->maxLength(255),

                    TextInput::make('password_confirmation')
                        ->label(__('lang.password_confirmation'))
                        ->required(fn(string $context): bool => $context === 'create')
                        ->password()
                        ->maxLength(255)->same('password'),

                ])
            ]);
    }
}
