<?php

namespace App\Filament\Resources\Users\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table->defaultSort('id', 'desc')->striped()
            ->columns([
                TextColumn::make('id')
                    ->label(__('lang.id'))
                    ->alignCenter()
                    ->toggleable()
                    ->searchable(),
                TextColumn::make('name')
                    ->label(__('lang.name'))
                    ->alignCenter(false)
                    ->toggleable()
                    ->searchable(),
                TextColumn::make('email')
                    ->label(__('lang.email'))
                    ->alignCenter(false)
                    ->toggleable()
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
