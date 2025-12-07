<?php

namespace App\Filament\Resources\StockTransfers\Tables;

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

class StockTransfersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('transfer_number')
                    ->label(__('lang.transfer_number'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('fromStore.name')
                    ->label(__('lang.from_store'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('toStore.name')
                    ->label(__('lang.to_store'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('transfer_date')
                    ->label(__('lang.transfer_date'))
                    ->date()
                    ->sortable(),

                TextColumn::make('status')
                    ->label(__('lang.status'))
                    ->badge()
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'pending' => __('lang.transfer_pending'),
                        'approved' => __('lang.transfer_approved'),
                        'in_transit' => __('lang.transfer_in_transit'),
                        'completed' => __('lang.transfer_completed'),
                        'cancelled' => __('lang.transfer_cancelled'),
                        default => $state,
                    })
                    ->color(fn(string $state): string => match ($state) {
                        'pending' => 'warning',
                        'approved' => 'info',
                        'in_transit' => 'primary',
                        'completed' => 'success',
                        'cancelled' => 'danger',
                        default => 'gray',
                    }),

                TextColumn::make('items_count')
                    ->label(__('lang.items_count'))
                    ->counts('items')
                    ->sortable(),

                TextColumn::make('createdBy.name')
                    ->label(__('lang.created_by'))
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('approvedBy.name')
                    ->label(__('lang.approved_by'))
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('created_at')
                    ->label(__('lang.created'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('transfer_date', 'desc')
            ->filters([
                SelectFilter::make('status')
                    ->label(__('lang.status'))
                    ->options([
                        'pending' => __('lang.transfer_pending'),
                        'approved' => __('lang.transfer_approved'),
                        'in_transit' => __('lang.transfer_in_transit'),
                        'completed' => __('lang.transfer_completed'),
                        'cancelled' => __('lang.transfer_cancelled'),
                    ]),

                SelectFilter::make('from_store_id')
                    ->label(__('lang.from_store'))
                    ->relationship('fromStore', 'name')
                    ->searchable()
                    ->preload(),

                SelectFilter::make('to_store_id')
                    ->label(__('lang.to_store'))
                    ->relationship('toStore', 'name')
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
