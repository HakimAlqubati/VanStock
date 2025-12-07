<?php

namespace App\Filament\Resources\InventoryTransactions\Tables;

use App\Constants;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class InventoryTransactionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label(__('lang.id'))
                    ->sortable()
                    ->searchable(),

                TextColumn::make('product.name')
                    ->label(__('lang.product'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('store.name')
                    ->label(__('lang.store'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('movement_type')
                    ->label(__('lang.movement_type'))
                    ->badge()
                    ->formatStateUsing(fn(string $state): string => __("lang.{$state}"))
                    ->color(fn(string $state): string => match ($state) {
                        'in' => 'success',
                        'out' => 'danger',
                        default => 'gray',
                    }),

                TextColumn::make('quantity')
                    ->label(__('lang.quantity'))
                    ->numeric(decimalPlaces: 4)
                    ->sortable(),

                TextColumn::make('unit.name')
                    ->label(__('lang.unit'))
                    ->sortable(),

                TextColumn::make('price')
                    ->label(__('lang.unit_price'))
                    ->money(Constants::CURRENCY)
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('movement_date')
                    ->label(__('lang.movement_date'))
                    ->date()
                    ->sortable(),

                TextColumn::make('remaining_quantity')
                    ->label(__('lang.remaining_quantity'))
                    ->numeric(decimalPlaces: 4)
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('base_quantity')
                    ->label(__('lang.base_quantity'))
                    ->numeric(decimalPlaces: 4)
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('baseUnit.name')
                    ->label(__('lang.base_unit'))
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('transactionable_type')
                    ->label(__('lang.transactionable'))
                    ->formatStateUsing(fn(?string $state): string => $state ? class_basename($state) : '-')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('created_at')
                    ->label(__('lang.created'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('movement_date', 'desc')
            ->filters([
                SelectFilter::make('movement_type')
                    ->label(__('lang.movement_type'))
                    ->options([
                        'in' => __('lang.movement_in'),
                        'out' => __('lang.movement_out'),
                    ]),

                SelectFilter::make('product_id')
                    ->label(__('lang.product'))
                    ->relationship('product', 'name')
                    ->searchable()
                    ->preload(),

                SelectFilter::make('store_id')
                    ->label(__('lang.store'))
                    ->relationship('store', 'name')
                    ->searchable()
                    ->preload(),

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
