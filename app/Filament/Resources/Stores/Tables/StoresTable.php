<?php

namespace App\Filament\Resources\Stores\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class StoresTable
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

                Tables\Columns\TextColumn::make('location')
                    ->label(__('lang.location'))
                    ->sortable()
                    ->searchable()
                    ->toggleable()
                    ->limit(40),

                Tables\Columns\TextColumn::make('storekeeper.name')
                    ->label(__('lang.storekeeper'))
                    ->sortable()
                    ->searchable()
                    ->toggleable(),

                Tables\Columns\IconColumn::make('active')
                    ->label(__('lang.active'))
                    ->boolean()
                    ->sortable()
                    ->toggleable()
                    ->alignCenter(),

                Tables\Columns\IconColumn::make('default_store')
                    ->label(__('lang.default_store'))
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

                Tables\Columns\TextColumn::make('deleted_at')
                    ->label(__('lang.deleted_at'))
                    ->dateTime('Y-m-d H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TrashedFilter::make(),

                SelectFilter::make('active')
                    ->label(__('lang.active'))
                    ->options([
                        '1' => __('lang.yes'),
                        '0' => __('lang.no'),
                    ]),

                SelectFilter::make('default_store')
                    ->label(__('lang.default_store'))
                    ->options([
                        '1' => __('lang.yes'),
                        '0' => __('lang.no'),
                    ]),

                SelectFilter::make('storekeeper_id')
                    ->label(__('lang.storekeeper'))
                    ->relationship('storekeeper', 'name')
                    ->searchable()
                    ->preload(),
            ])
            ->recordActions([
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
