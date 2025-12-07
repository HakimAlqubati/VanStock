<?php

namespace App\Filament\Resources\SalesInvoices\Tables;

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

class SalesInvoicesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('invoice_number')
                    ->label(__('lang.invoice_number'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('salesOrder.order_number')
                    ->label(__('lang.from_order'))
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

                TextColumn::make('invoice_date')
                    ->label(__('lang.invoice_date'))
                    ->date()
                    ->sortable(),

                TextColumn::make('due_date')
                    ->label(__('lang.due_date'))
                    ->date()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('payment_status')
                    ->label(__('lang.payment_status'))
                    ->badge()
                    ->formatStateUsing(fn(string $state): string => __("lang.{$state}"))
                    ->color(fn(string $state): string => match ($state) {
                        'paid' => 'success',
                        'partial' => 'warning',
                        'unpaid' => 'danger',
                        'overdue' => 'danger',
                        default => 'gray',
                    }),

                TextColumn::make('items_count')
                    ->label(__('lang.items_count'))
                    ->counts('items')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('total_amount')
                    ->label(__('lang.total_amount'))
                    ->money(Constants::CURRENCY)
                    ->sortable(),

                TextColumn::make('paid_amount')
                    ->label(__('lang.paid_amount'))
                    ->money(Constants::CURRENCY)
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('remaining_amount')
                    ->label(__('lang.remaining_amount'))
                    ->getStateUsing(fn($record) => $record->total_amount - $record->paid_amount)
                    ->money(Constants::CURRENCY)
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('created_at')
                    ->label(__('lang.created'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('invoice_date', 'desc')
            ->filters([
                SelectFilter::make('payment_status')
                    ->label(__('lang.payment_status'))
                    ->options([
                        'unpaid' => __('lang.unpaid'),
                        'partial' => __('lang.partial'),
                        'paid' => __('lang.paid'),
                        'overdue' => __('lang.overdue'),
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
