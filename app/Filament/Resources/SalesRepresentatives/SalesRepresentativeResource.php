<?php

namespace App\Filament\Resources\SalesRepresentatives;

use App\Filament\Resources\SalesRepresentatives\Pages\CreateSalesRepresentative;
use App\Filament\Resources\SalesRepresentatives\Pages\EditSalesRepresentative;
use App\Filament\Resources\SalesRepresentatives\Pages\ListSalesRepresentatives;
use App\Filament\Resources\SalesRepresentatives\Pages\ViewSalesRepresentative;
use App\Filament\Resources\SalesRepresentatives\RelationManagers\AssignmentsRelationManager;
use App\Filament\Resources\SalesRepresentatives\Schemas\SalesRepresentativeForm;
use App\Filament\Resources\SalesRepresentatives\Schemas\SalesRepresentativeInfolist;
use App\Filament\Resources\SalesRepresentatives\Tables\SalesRepresentativesTable;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\SalesRepresentative;

class SalesRepresentativeResource extends Resource
{
    protected static ?string $model = SalesRepresentative::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserMinus;

    protected static ?string $recordTitleAttribute = 'name';

    public static function getNavigationGroup(): ?string
    {
        return __('lang.sales_representatives');
    }

    public static function getModelLabel(): string
    {
        return __('menu.sales_representative');
    }

    public static function getPluralLabel(): ?string
    {
        return __('menu.sales_representatives');
    }

    public static function getNavigationLabel(): string
    {
        return __('menu.sales_representatives');
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Schema $schema): Schema
    {
        return SalesRepresentativeForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return SalesRepresentativeInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SalesRepresentativesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            AssignmentsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSalesRepresentatives::route('/'),
            'create' => CreateSalesRepresentative::route('/create'),
            'view' => ViewSalesRepresentative::route('/{record}'),
            'edit' => EditSalesRepresentative::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
