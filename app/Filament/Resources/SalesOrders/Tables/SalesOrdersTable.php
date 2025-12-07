<?php

namespace App\Filament\Resources\SalesOrders\Tables;

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

class SalesOrdersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('order_number')
                    ->label(__('lang.order_number'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('customer.name')
                    ->label(__('lang.customer'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('salesRepresentative.user.name')
                    ->label(__('lang.sale_representative'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('store.name')
                    ->label(__('lang.store'))
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('order_date')
                    ->label(__('lang.order_date'))
                    ->date()
                    ->sortable(),

                TextColumn::make('delivery_date')
                    ->label(__('lang.delivery_date'))
                    ->date()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('status')
                    ->label(__('lang.status'))
                    ->badge()
                    ->formatStateUsing(fn(string $state): string => __("lang.{$state}"))
                    ->color(fn(string $state): string => match ($state) {
                        'pending' => 'warning',
                        'confirmed' => 'info',
                        'processing' => 'primary',
                        'shipped' => 'secondary',
                        'delivered' => 'success',
                        'cancelled' => 'danger',
                        default => 'gray',
                    }),

                TextColumn::make('items_count')
                    ->label(__('lang.items_count'))
                    ->counts('items')
                    ->sortable(),

                TextColumn::make('total_amount')
                    ->label(__('lang.total_amount'))
                    ->money(Constants::CURRENCY)
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label(__('lang.created'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('order_date', 'desc')
            ->filters([
                SelectFilter::make('status')
                    ->label(__('lang.status'))
                    ->options([
                        'pending' => __('lang.pending'),
                        'confirmed' => __('lang.confirmed'),
                        'processing' => __('lang.processing'),
                        'shipped' => __('lang.shipped'),
                        'delivered' => __('lang.delivered'),
                        'cancelled' => __('lang.cancelled'),
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
