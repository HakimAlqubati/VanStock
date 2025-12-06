<?php

namespace App\Filament\Resources\SalesRepresentatives\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class SalesRepresentativesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                \Filament\Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                \Filament\Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                \Filament\Tables\Columns\TextColumn::make('phone')
                    ->searchable(),
                \Filament\Tables\Columns\TextColumn::make('rep_code')
                    ->searchable(),
                \Filament\Tables\Columns\TextColumn::make('user.name')
                    ->label('User')
                    ->sortable(),
                \Filament\Tables\Columns\TextColumn::make('currentVehicle.plate_number')
                    ->label('Vehicle')
                    ->sortable(),
                \Filament\Tables\Columns\TextColumn::make('cash_wallet')
                    ->money()
                    ->sortable(),
                \Filament\Tables\Columns\TextColumn::make('credit_limit_allowance')
                    ->money()
                    ->sortable(),
                \Filament\Tables\Columns\TextColumn::make('commission_rate')
                    ->numeric()
                    ->sortable(),
                \Filament\Tables\Columns\ToggleColumn::make('is_active'),
                \Filament\Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                \Filament\Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}
