<?php

namespace App\Filament\Resources\SalesRepresentatives\RelationManagers;

use App\Models\Vehicle;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AssignmentsRelationManager extends RelationManager
{
    protected static string $relationship = 'assignments';

    protected static ?string $recordTitleAttribute = 'id';

    public static function getTitle($ownerRecord, string $pageClass): string
    {
        return __('lang.vehicle_assignments');
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('vehicle_id')
                    ->label(__('lang.vehicle'))
                    ->options(Vehicle::pluck('plate_number', 'id'))
                    ->searchable()
                    ->preload()
                    ->required(),

                DateTimePicker::make('assigned_at')
                    ->label(__('lang.assigned_at'))
                    ->required()
                    ->default(now())
                    ->native(false),

                DateTimePicker::make('returned_at')
                    ->label(__('lang.returned_at'))
                    ->native(false),

                TextInput::make('start_odometer')
                    ->label(__('lang.start_odometer'))
                    ->numeric()
                    ->step(0.01),

                TextInput::make('end_odometer')
                    ->label(__('lang.end_odometer'))
                    ->numeric()
                    ->step(0.01),

                Textarea::make('notes')
                    ->label(__('lang.notes'))
                    ->rows(3)
                    ->columnSpanFull(),
            ])
            ->columns(2);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('vehicle.plate_number')
                    ->label(__('lang.vehicle'))
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('info'),

                TextColumn::make('assigned_at')
                    ->label(__('lang.assigned_at'))
                    ->dateTime('Y-m-d H:i')
                    ->sortable(),

                TextColumn::make('returned_at')
                    ->label(__('lang.returned_at'))
                    ->dateTime('Y-m-d H:i')
                    ->sortable()
                    ->placeholder(__('lang.not_returned_yet')),

                TextColumn::make('start_odometer')
                    ->label(__('lang.start_odometer'))
                    ->numeric(decimalPlaces: 2)
                    ->suffix(' km')
                    ->alignEnd(),

                TextColumn::make('end_odometer')
                    ->label(__('lang.end_odometer'))
                    ->numeric(decimalPlaces: 2)
                    ->suffix(' km')
                    ->alignEnd()
                    ->placeholder('-'),

                TextColumn::make('notes')
                    ->label(__('lang.notes'))
                    ->limit(30)
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('created_at')
                    ->label(__('lang.created'))
                    ->dateTime('Y-m-d')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('assigned_at', 'desc')
            ->headerActions([
                CreateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
