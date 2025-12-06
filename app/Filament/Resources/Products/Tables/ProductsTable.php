<?php

namespace App\Filament\Resources\Products\Tables;

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

class ProductsTable
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
                    ->toggleable()
                    ->limit(40),

                Tables\Columns\TextColumn::make('slug')
                    ->label(__('lang.slug'))
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->limit(30),

                Tables\Columns\TextColumn::make('category.name')
                    ->label(__('lang.category'))
                    ->sortable()
                    ->searchable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('brand.name')
                    ->label(__('lang.brand'))
                    ->sortable()
                    ->searchable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('status')
                    ->label(__('lang.status'))
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'draft' => 'gray',
                        'active' => 'success',
                        'inactive' => 'danger',
                        default => 'gray',
                    })
                    ->sortable()
                    ->toggleable()
                    ->alignCenter(),

                Tables\Columns\IconColumn::make('is_featured')
                    ->label(__('lang.is_featured'))
                    ->boolean()
                    ->sortable()
                    ->toggleable()
                    ->alignCenter(),

                // Tables\Columns\TextColumn::make('productUnitsCount')
                //     ->counts('productUnits')
                //     ->label(__('lang.units'))
                //     ->sortable()
                //     ->toggleable()
                //     ->alignCenter(),

                Tables\Columns\TextColumn::make('creator.name')
                    ->label(__('lang.created_by'))
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

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

                SelectFilter::make('status')
                    ->label(__('lang.status'))
                    ->options([
                        'draft' => __('lang.draft'),
                        'active' => __('lang.active'),
                        'inactive' => __('lang.inactive'),
                    ]),

                SelectFilter::make('category_id')
                    ->label(__('lang.category'))
                    ->relationship('category', 'name')
                    ->searchable()
                    ->preload(),

                SelectFilter::make('brand_id')
                    ->label(__('lang.brand'))
                    ->relationship('brand', 'name')
                    ->searchable()
                    ->preload(),

                SelectFilter::make('is_featured')
                    ->label(__('lang.is_featured'))
                    ->options([
                        '1' => __('lang.yes'),
                        '0' => __('lang.no'),
                    ]),
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
