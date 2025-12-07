<?php

namespace App\Filament\Resources\SalesReturns\Tables;

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

class SalesReturnsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('return_number')
                    ->label(__('lang.return_number'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('salesInvoice.invoice_number')
                    ->label(__('lang.from_invoice'))
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('customer.name')
                    ->label(__('lang.customer'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('salesRepresentative.user.name')
                    ->label(__('lang.sale_representative'))
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('store.name')
                    ->label(__('lang.store'))
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('return_date')
                    ->label(__('lang.return_date'))
                    ->date()
                    ->sortable(),

                TextColumn::make('status')
                    ->label(__('lang.status'))
                    ->badge()
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'pending' => __('lang.return_pending'),
                        'approved' => __('lang.return_approved'),
                        'rejected' => __('lang.return_rejected'),
                        default => $state,
                    })
                    ->color(fn(string $state): string => match ($state) {
                        'approved' => 'success',
                        'pending' => 'warning',
                        'rejected' => 'danger',
                        default => 'gray',
                    }),

                TextColumn::make('items_count')
                    ->label(__('lang.items_count'))
                    ->counts('items')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('total_amount')
                    ->label(__('lang.total_amount'))
                    ->money('YER')
                    ->sortable(),

                TextColumn::make('reason')
                    ->label(__('lang.reason'))
                    ->limit(30)
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('created_at')
                    ->label(__('lang.created'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('return_date', 'desc')
            ->filters([
                SelectFilter::make('status')
                    ->label(__('lang.status'))
                    ->options([
                        'pending' => __('lang.return_pending'),
                        'approved' => __('lang.return_approved'),
                        'rejected' => __('lang.return_rejected'),
                    ]),

                SelectFilter::make('customer_id')
                    ->label(__('lang.customer'))
                    ->relationship('customer', 'name')
                    ->searchable()
                    ->preload(),

                SelectFilter::make('sales_representative_id')
                    ->label(__('lang.sale_representative'))
                    ->relationship('salesRepresentative.user', 'name')
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
