<?php

namespace App\Filament\Resources\Roles\Schemas;

use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Schema;
use Spatie\Permission\Models\Permission;

class RoleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Fieldset::make(__('lang.role'))
                    ->columnSpanFull()
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                            ->label(__('lang.role_name'))
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),

                        TextInput::make('guard_name')
                            ->label(__('lang.guard_name'))
                            ->default('web')
                            ->required()
                            ->maxLength(255),
                    ]),

                Fieldset::make(__('lang.assign_permissions'))
                    ->columnSpanFull()
                    ->schema([
                        CheckboxList::make('permissions')
                            ->label(__('lang.permissions'))
                            ->relationship('permissions', 'name')
                            ->options(function () {
                                return Permission::all()->pluck('name', 'id');
                            })
                            ->columns(3)
                            ->searchable()
                            ->bulkToggleable(),
                    ]),
            ]);
    }
}
