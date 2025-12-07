<?php

namespace App\Filament\Resources\StockIssueOrders\Tables;

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

class StockIssueOrdersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('issue_number')
                    ->label(__('lang.issue_number'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('store.name')
                    ->label(__('lang.store'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('issue_date')
                    ->label(__('lang.issue_date'))
                    ->date()
                    ->sortable(),

                TextColumn::make('status')
                    ->label(__('lang.status'))
                    ->badge()
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'pending' => __('lang.issue_pending'),
                        'approved' => __('lang.issue_approved'),
                        'issued' => __('lang.issue_issued'),
                        'cancelled' => __('lang.issue_cancelled'),
                        default => $state,
                    })
                    ->color(fn(string $state): string => match ($state) {
                        'pending' => 'warning',
                        'approved' => 'info',
                        'issued' => 'success',
                        'cancelled' => 'danger',
                        default => 'gray',
                    }),

                TextColumn::make('recipient_name')
                    ->label(__('lang.recipient_name'))
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('recipient_department')
                    ->label(__('lang.recipient_department'))
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('items_count')
                    ->label(__('lang.items_count'))
                    ->counts('items')
                    ->sortable(),

                TextColumn::make('createdBy.name')
                    ->label(__('lang.created_by'))
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('created_at')
                    ->label(__('lang.created'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('issue_date', 'desc')
            ->filters([
                SelectFilter::make('status')
                    ->label(__('lang.status'))
                    ->options([
                        'pending' => __('lang.issue_pending'),
                        'approved' => __('lang.issue_approved'),
                        'issued' => __('lang.issue_issued'),
                        'cancelled' => __('lang.issue_cancelled'),
                    ]),

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
