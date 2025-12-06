<?php

namespace App\Filament\Resources\Products\Schemas;

use App\Models\Product;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Wizard;
use Filament\Schemas\Components\Wizard\Step;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Fieldset::make()->columnSpanFull()->schema([
                    Wizard::make()->columnSpanFull()->steps([
                        // Step 1: Basic Information
                        Step::make(__('lang.basic_info'))
                            ->icon('heroicon-o-information-circle')
                            ->columnSpanFull()
                            ->schema([
                                Grid::make(2)->schema([
                                    TextInput::make('name')
                                        ->label(__('lang.name'))
                                        ->required()
                                        ->maxLength(255)
                                        ->live(onBlur: true)
                                        ->afterStateUpdated(fn($state, callable $set) => $set('slug', Str::slug($state)))
                                        ->columnSpan(1),

                                    TextInput::make('slug')
                                        ->label(__('lang.slug'))
                                        ->required()
                                        ->maxLength(255)
                                        ->unique(ignoreRecord: true)
                                        ->columnSpan(1),
                                ]),

                                Grid::make(3)->schema([
                                    Select::make('category_id')
                                        ->label(__('lang.category'))
                                        ->relationship('category', 'name')
                                        ->searchable()
                                        ->preload()
                                        ->nullable()
                                        ->columnSpan(1),

                                    Select::make('brand_id')
                                        ->label(__('lang.brand'))
                                        ->relationship('brand', 'name')
                                        ->searchable()
                                        ->preload()
                                        ->nullable()
                                        ->columnSpan(1),

                                    Select::make('status')
                                        ->label(__('lang.status'))
                                        ->options([
                                            'draft' => __('lang.draft'),
                                            'active' => __('lang.active'),
                                            'inactive' => __('lang.inactive'),
                                        ])
                                        ->default('draft')
                                        ->required()
                                        ->columnSpan(1),
                                ]),

                                Toggle::make('is_featured')
                                    ->label(__('lang.is_featured'))
                                    ->default(false)
                                    ->inline(false),

                                Textarea::make('short_description')
                                    ->label(__('lang.short_description'))
                                    ->rows(3)
                                    ->columnSpanFull(),

                                RichEditor::make('description')
                                    ->label(__('lang.description'))
                                    ->columnSpanFull(),
                            ]),

                        // Step 2: Product Units
                        Step::make(__('lang.product_units'))
                            ->icon('heroicon-o-cube')
                            ->columnSpanFull()
                            ->schema([
                                Repeater::make('units')
                                    ->relationship('productUnits')
                                    ->label(__('lang.product_units'))
                                    ->addActionLabel(__('lang.add_unit'))
                                    ->collapsible()
                                    ->cloneable()
                                    ->defaultItems(1)
                                    ->columnSpanFull()
                                    ->schema([
                                        Grid::make(4)->schema([
                                            Select::make('unit_id')
                                                ->label(__('lang.unit'))
                                                ->relationship('unit', 'name')
                                                ->searchable()
                                                ->preload()
                                                ->required()
                                                ->columnSpan(1),

                                            TextInput::make('package_size')
                                                ->label(__('lang.package_size'))
                                                ->numeric()
                                                ->default(1)
                                                ->minValue(1)
                                                ->required()
                                                ->columnSpan(1),

                                            TextInput::make('cost_price')
                                                ->label(__('lang.cost_price'))
                                                ->numeric()
                                                ->prefix('$')
                                                ->columnSpan(1),

                                            TextInput::make('selling_price')
                                                ->label(__('lang.selling_price'))
                                                ->numeric()
                                                ->prefix('$')
                                                ->columnSpan(1),
                                        ]),

                                        Grid::make(4)->schema([
                                            TextInput::make('stock')
                                                ->label(__('lang.stock'))
                                                ->numeric()
                                                ->default(0)
                                                ->columnSpan(1),

                                            TextInput::make('moq')
                                                ->label(__('lang.moq'))
                                                ->numeric()
                                                ->default(1)
                                                ->minValue(1)
                                                ->columnSpan(1),

                                            TextInput::make('sort_order')
                                                ->label(__('lang.sort_order'))
                                                ->numeric()
                                                ->default(0)
                                                ->columnSpan(1),

                                            Toggle::make('is_default')
                                                ->label(__('lang.is_default'))
                                                ->default(false)
                                                ->inline(false)
                                                ->columnSpan(1),
                                        ]),
                                    ]),
                            ]),
                    ])
                ])
            ]);
    }
}
