<?php

namespace App\Filament\Resources\StockSupplyOrders;

use App\Filament\Resources\StockSupplyOrders\Pages\CreateStockSupplyOrder;
use App\Filament\Resources\StockSupplyOrders\Pages\EditStockSupplyOrder;
use App\Filament\Resources\StockSupplyOrders\Pages\ListStockSupplyOrders;
use App\Filament\Resources\StockSupplyOrders\Pages\ViewStockSupplyOrder;
use App\Filament\Resources\StockSupplyOrders\Schemas\StockSupplyOrderForm;
use App\Filament\Resources\StockSupplyOrders\Schemas\StockSupplyOrderInfolist;
use App\Filament\Resources\StockSupplyOrders\Tables\StockSupplyOrdersTable;
use App\Models\StockSupplyOrder;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StockSupplyOrderResource extends Resource
{
    protected static ?string $model = StockSupplyOrder::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedArrowUpTray;

    protected static ?string $recordTitleAttribute = 'supply_number';

    public static function getModelLabel(): string
    {
        return __('lang.stock_supply_order');
    }

    public static function getPluralLabel(): ?string
    {
        return __('lang.stock_supply_orders');
    }

    public static function getNavigationLabel(): string
    {
        return __('lang.stock_supply_orders');
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Schema $schema): Schema
    {
        return StockSupplyOrderForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return StockSupplyOrderInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return StockSupplyOrdersTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListStockSupplyOrders::route('/'),
            'create' => CreateStockSupplyOrder::route('/create'),
            'view' => ViewStockSupplyOrder::route('/{record}'),
            'edit' => EditStockSupplyOrder::route('/{record}/edit'),
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
