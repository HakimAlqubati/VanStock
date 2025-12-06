<?php

namespace App\Filament\Resources\SalesRepresentatives\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class SalesRepresentativesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->striped()
            ->defaultSort('id', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label(__('lang.id'))
                    ->sortable()
                    ->searchable()
                    ->toggleable()
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('name')
                    ->label(__('lang.name'))
                    ->sortable()
                    ->searchable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('rep_code')
                    ->label(__('lang.rep_code'))
                    ->sortable()
                    ->searchable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('email')
                    ->label(__('lang.email'))
                    ->sortable()
                    ->searchable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('phone')
                    ->label(__('lang.phone'))
                    ->sortable()
                    ->searchable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('user.name')
                    ->label(__('lang.user'))
                    ->sortable()
                    ->searchable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('currentVehicle.plate_number')
                    ->label(__('lang.current_vehicle'))
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('cash_wallet')
                    ->label(__('lang.cash_wallet'))
                    ->money()
                    ->sortable()
                    ->toggleable()
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('credit_limit_allowance')
                    ->label(__('lang.credit_limit_allowance'))
                    ->money()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('commission_rate')
                    ->label(__('lang.commission_rate'))
                    ->numeric()
                    ->suffix('%')
                    ->sortable()
                    ->toggleable()
                    ->alignCenter(),

                Tables\Columns\IconColumn::make('is_active')
                    ->label(__('lang.is_active'))
                    ->boolean()
                    ->sortable()
                    ->toggleable()
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('lang.created'))
                    ->dateTime('Y-m-d H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label(__('lang.updated'))
                    ->dateTime('Y-m-d H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TrashedFilter::make(),

                SelectFilter::make('is_active')
                    ->label(__('lang.is_active'))
                    ->options([
                        '1' => __('lang.yes'),
                        '0' => __('lang.no'),
                    ]),

                SelectFilter::make('current_vehicle_id')
                    ->label(__('lang.current_vehicle'))
                    ->relationship('currentVehicle', 'plate_number')
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
