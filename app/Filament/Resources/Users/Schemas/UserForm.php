<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Fieldset::make()->columnSpanFull()->columns(2)->schema([
                    TextInput::make('name')->required()->maxLength(255),
                    TextInput::make('email')->required()->maxLength(255),
                    TextInput::make('password')->password()
                    ->required()->maxLength(255),
                    
                    TextInput::make('password_confirmation')->password()
                    ->required()->maxLength(255)->same('password'),

                ])
            ]);
    }
}
