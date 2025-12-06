<?php

namespace App\Providers\Filament;

use App\Filament\Resources\Categories\CategoryResource;
use App\Filament\Resources\Cities\CityResource;
use App\Filament\Resources\Countries\CountryResource;
use App\Filament\Resources\Districts\DistrictResource;
use App\Filament\Resources\Products\ProductResource;
use App\Filament\Resources\SalesRepresentatives\SalesRepresentativeResource;
use App\Filament\Resources\Stores\StoreResource;
use App\Filament\Resources\Units\UnitResource;
use App\Filament\Resources\Users\UserResource;
use App\Filament\Resources\Vehicles\VehicleResource;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationBuilder;
use Filament\Navigation\NavigationGroup;
use Filament\Navigation\NavigationItem;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->brandName('Qafilah')
            ->favicon(asset('/imgs/logo.png'))
            ->brandLogo(asset('/imgs/logo.png'))
            ->brandLogoHeight('3.0rem')
            ->colors([
                'primary' => '#00172cff',
            ])
            ->navigation(function (NavigationBuilder $builder): NavigationBuilder {
                return $builder->items([
                    NavigationItem::make(__('lang.dashboard'))
                        ->icon('heroicon-o-home')
                        // ->isActiveWhen(fn(): bool => original_request()->routeIs('filament.admin.pages.dashboard'))
                        ->url(fn(): string => Dashboard::getUrl()),

                    // ...UserResource::getNavigationItems(),
                    // ...Settings::getNavigationItems(),
                ])->groups([

                    NavigationGroup::make(__('menu.users_management'))
                        ->items([
                            ...UserResource::getNavigationItems(),
                        ]),
                    NavigationGroup::make(__('menu.sales_and_vehicles'))
                        ->items([
                            ...VehicleResource::getNavigationItems(),
                            ...SalesRepresentativeResource::getNavigationItems(),
                        ]),
                    NavigationGroup::make(__('lang.location_management'))
                        ->items([
                            ...CountryResource::getNavigationItems(),
                            ...CityResource::getNavigationItems(),
                            ...DistrictResource::getNavigationItems(),
                        ]),
                    NavigationGroup::make(__('lang.stores'))
                        ->items([
                            ...StoreResource::getNavigationItems(), 
                        ]),
                    NavigationGroup::make(__('menu.categories_and_units'))
                        ->items([
                            ...CategoryResource::getNavigationItems(),
                            ...UnitResource::getNavigationItems(),
                        ]),
                    NavigationGroup::make(__('menu.products'))
                        ->items([
                            ...ProductResource::getNavigationItems(),
                        ]),
                ]);
            })
            ->sidebarCollapsibleOnDesktop()
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
                AccountWidget::class,
                FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
