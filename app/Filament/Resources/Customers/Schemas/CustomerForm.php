<?php

namespace App\Filament\Resources\Customers\Schemas;

use App\Constants;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Wizard;
use Filament\Schemas\Components\Wizard\Step;
use Filament\Schemas\Schema;

class CustomerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Wizard::make([
                    // Step 1: Basic Customer Information
                    Step::make(__('lang.customer_information'))
                        ->icon('heroicon-o-user')
                        ->schema([
                            Grid::make(2)
                                ->schema([
                                    TextInput::make('name')
                                        ->label(__('lang.name'))
                                        ->required()
                                        ->maxLength(255),

                                    Select::make('customer_type')
                                        ->label(__('lang.customer_type'))
                                        ->options([
                                            'retail' => __('lang.retail'),
                                            'wholesale' => __('lang.wholesale'),
                                        ])
                                        ->default('retail')
                                        ->required(),
                                ]),

                            Grid::make(3)
                                ->schema([
                                    TextInput::make('phone')
                                        ->label(__('lang.phone'))
                                        ->tel()
                                        ->maxLength(20),

                                    TextInput::make('email')
                                        ->label(__('lang.email'))
                                        ->email()
                                        ->maxLength(255),

                                    TextInput::make('contact_person')
                                        ->label(__('lang.contact_person'))
                                        ->maxLength(255),
                                ]),

                            Toggle::make('active')
                                ->label(__('lang.is_active'))
                                ->default(true),
                        ]),

                    // Step 2: Location Information
                    Step::make(__('lang.location_info'))
                        ->icon('heroicon-o-map-pin')
                        ->schema([
                            Grid::make(2)
                                ->schema([
                                    Select::make('district_id')
                                        ->label(__('lang.district'))
                                        ->relationship('district', 'name')
                                        ->searchable()
                                        ->preload(),

                                    Textarea::make('address')
                                        ->label(__('lang.address'))
                                        ->rows(2),
                                ]),

                            Section::make(__('lang.gps_coordinates'))
                                ->schema([
                                    Grid::make(2)
                                        ->schema([
                                            TextInput::make('latitude')
                                                ->label(__('lang.latitude'))
                                                ->numeric()
                                                ->step(0.00000001),

                                            TextInput::make('longitude')
                                                ->label(__('lang.longitude'))
                                                ->numeric()
                                                ->step(0.00000001),
                                        ]),
                                ])
                                ->collapsed()
                                ->collapsible(),
                        ]),

                    // Step 3: Financial Information
                    Step::make(__('lang.financial_info'))
                        ->icon('heroicon-o-currency-dollar')
                        ->schema([
                            Grid::make(2)
                                ->schema([
                                    TextInput::make('credit_limit')
                                        ->label(__('lang.credit_limit'))
                                        ->numeric()
                                        ->default(0)
                                        ->prefix(Constants::CURRENCY),

                                    TextInput::make('balance')
                                        ->label(__('lang.balance'))
                                        ->numeric()
                                        ->default(0)
                                        ->prefix(Constants::CURRENCY)
                                        ->disabled()
                                        ->dehydrated(false),
                                ]),
                        ]),

                    // Step 4: Branches
                    Step::make(__('lang.customer_branches'))
                        ->icon('heroicon-o-building-storefront')
                        ->schema([
                            Repeater::make('branches')
                                ->relationship()
                                ->schema([
                                    Grid::make(3)
                                        ->schema([
                                            TextInput::make('name')
                                                ->label(__('lang.branch_name'))
                                                ->required()
                                                ->maxLength(255),

                                            TextInput::make('phone')
                                                ->label(__('lang.phone'))
                                                ->tel()
                                                ->maxLength(20),

                                            TextInput::make('contact_person')
                                                ->label(__('lang.contact_person'))
                                                ->maxLength(255),
                                        ]),

                                    Grid::make(2)
                                        ->schema([
                                            Select::make('district_id')
                                                ->label(__('lang.district'))
                                                ->relationship('district', 'name')
                                                ->searchable()
                                                ->preload(),

                                            Textarea::make('address')
                                                ->label(__('lang.address'))
                                                ->rows(2),
                                        ]),

                                    Grid::make(4)
                                        ->schema([
                                            TextInput::make('latitude')
                                                ->label(__('lang.latitude'))
                                                ->numeric()
                                                ->step(0.00000001),

                                            TextInput::make('longitude')
                                                ->label(__('lang.longitude'))
                                                ->numeric()
                                                ->step(0.00000001),

                                            Toggle::make('is_main')
                                                ->label(__('lang.is_main_branch'))
                                                ->default(false),

                                            Toggle::make('active')
                                                ->label(__('lang.is_active'))
                                                ->default(true),
                                        ]),
                                ])
                                ->addActionLabel(__('lang.add_branch'))
                                ->reorderable(false)
                                ->collapsible()
                                ->itemLabel(fn(array $state): ?string => $state['name'] ?? __('lang.customer_branch'))
                                ->columns(1),
                        ]),

                    // Step 5: Contact Information
                    Step::make(__('lang.customer_contacts'))
                        ->icon('heroicon-o-phone')
                        ->schema([
                            Repeater::make('contactInfo')
                                ->relationship()
                                ->schema([
                                    Grid::make(4)
                                        ->schema([
                                            Select::make('contact_type')
                                                ->label(__('lang.contact_type'))
                                                ->options([
                                                    'phone' => __('lang.contact_phone'),
                                                    'mobile' => __('lang.contact_mobile'),
                                                    'email' => __('lang.contact_email'),
                                                    'whatsapp' => __('lang.contact_whatsapp'),
                                                    'fax' => __('lang.contact_fax'),
                                                    'website' => __('lang.contact_website'),
                                                ])
                                                ->required(),

                                            TextInput::make('contact_value')
                                                ->label(__('lang.contact_value'))
                                                ->required()
                                                ->maxLength(255),

                                            Select::make('label')
                                                ->label(__('lang.contact_label'))
                                                ->options([
                                                    'work' => __('lang.work'),
                                                    'personal' => __('lang.personal'),
                                                    'sales' => __('lang.sales_dept'),
                                                    'accounting' => __('lang.accounting_dept'),
                                                ]),

                                            Toggle::make('is_primary')
                                                ->label(__('lang.is_primary'))
                                                ->default(false),
                                        ]),

                                    Textarea::make('notes')
                                        ->label(__('lang.notes'))
                                        ->rows(1)
                                        ->columnSpanFull(),
                                ])
                                ->addActionLabel(__('lang.add_contact'))
                                ->reorderable(false)
                                ->collapsible()
                                ->itemLabel(
                                    fn(array $state): ?string =>
                                    isset($state['contact_type'], $state['contact_value'])
                                        ? "{$state['contact_type']}: {$state['contact_value']}"
                                        : __('lang.contact_info')
                                )
                                ->columns(1),
                        ]),
                ])
                    ->skippable()
                    ->columnSpanFull(),
            ]);
    }
}
