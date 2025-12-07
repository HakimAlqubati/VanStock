<?php

namespace App\Filament\Resources\StockIssueOrders;

use App\Filament\Resources\StockIssueOrders\Pages\CreateStockIssueOrder;
use App\Filament\Resources\StockIssueOrders\Pages\EditStockIssueOrder;
use App\Filament\Resources\StockIssueOrders\Pages\ListStockIssueOrders;
use App\Filament\Resources\StockIssueOrders\Pages\ViewStockIssueOrder;
use App\Filament\Resources\StockIssueOrders\Schemas\StockIssueOrderForm;
use App\Filament\Resources\StockIssueOrders\Schemas\StockIssueOrderInfolist;
use App\Filament\Resources\StockIssueOrders\Tables\StockIssueOrdersTable;
use App\Models\StockIssueOrder;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StockIssueOrderResource extends Resource
{
    protected static ?string $model = StockIssueOrder::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedArrowDownTray;

    protected static ?string $recordTitleAttribute = 'issue_number';

    public static function getModelLabel(): string
    {
        return __('lang.stock_issue_order');
    }

    public static function getPluralLabel(): ?string
    {
        return __('lang.stock_issue_orders');
    }

    public static function getNavigationLabel(): string
    {
        return __('lang.stock_issue_orders');
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Schema $schema): Schema
    {
        return StockIssueOrderForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return StockIssueOrderInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return StockIssueOrdersTable::configure($table);
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
            'index' => ListStockIssueOrders::route('/'),
            'create' => CreateStockIssueOrder::route('/create'),
            'view' => ViewStockIssueOrder::route('/{record}'),
            'edit' => EditStockIssueOrder::route('/{record}/edit'),
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
