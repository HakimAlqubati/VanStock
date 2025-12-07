<?php

namespace App\Filament\Resources\Customers\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class CustomersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label(__('lang.id'))
                    ->sortable()
                    ->searchable(),

                TextColumn::make('name')
                    ->label(__('lang.name'))
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('phone')
                    ->label(__('lang.phone'))
                    ->searchable()
                    ->copyable()
                    ->icon('heroicon-o-phone'),

                TextColumn::make('customer_type')
                    ->label(__('lang.customer_type'))
                    ->badge()
                    ->formatStateUsing(fn(string $state): string => __("lang.{$state}"))
                    ->color(fn(string $state): string => match ($state) {
                        'wholesale' => 'success',
                        'retail' => 'info',
                        default => 'gray',
                    }),

                TextColumn::make('district.name')
                    ->label(__('lang.district'))
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('credit_limit')
                    ->label(__('lang.credit_limit'))
                    ->money('YER')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('balance')
                    ->label(__('lang.balance'))
                    ->money('YER')
                    ->sortable()
                    ->color(fn($state) => $state > 0 ? 'danger' : 'success'),

                IconColumn::make('active')
                    ->label(__('lang.status'))
                    ->boolean()
                    ->sortable(),

                TextColumn::make('salesOrders_count')
                    ->label(__('lang.total_orders'))
                    ->counts('salesOrders')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('salesInvoices_count')
                    ->label(__('lang.total_invoices'))
                    ->counts('salesInvoices')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('created_at')
                    ->label(__('lang.created'))
                    ->dateTime('Y-m-d')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('id', 'desc')
            ->filters([
                TrashedFilter::make(),

                SelectFilter::make('customer_type')
                    ->label(__('lang.customer_type'))
                    ->options([
                        'retail' => __('lang.retail'),
                        'wholesale' => __('lang.wholesale'),
                    ]),

                TernaryFilter::make('active')
                    ->label(__('lang.status')),

                SelectFilter::make('district_id')
                    ->label(__('lang.district'))
                    ->relationship('district', 'name')
                    ->searchable()
                    ->preload(),
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
