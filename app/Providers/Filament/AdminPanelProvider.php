<?php

namespace App\Providers\Filament;

use App\Filament\Widgets\OrdersChartWidget;
use App\Filament\Widgets\OrderStatusChartWidget;
use App\Filament\Widgets\RecentOrdersWidget;
use App\Filament\Widgets\RestaurantOverviewHeaderWidget;
use App\Filament\Widgets\StatsOverviewWidget;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\Width;
use Filament\View\PanelsRenderHook;
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
            ->brandName('DanishKada')
            ->brandLogo(fn () => view('filament.admin.logo'))
            ->brandLogoHeight('2.75rem')
            ->font('Outfit')
            ->colors([
                'primary' => Color::Amber,
                'gray' => Color::Slate,
                'info' => Color::Sky,
                'success' => Color::Emerald,
                'warning' => Color::Amber,
                'danger' => Color::Rose,
            ])
            ->sidebarCollapsibleOnDesktop()
            ->sidebarWidth('17rem')
            ->maxContentWidth(Width::Full)
            ->spa()
            ->databaseNotifications()
            ->databaseNotificationsPolling('30s')
            ->navigationGroups([
                'Order Management',
                'Menu & Catalog',
                'Customers & Feedback',
                'Store Settings',
            ])
            ->renderHook(
                PanelsRenderHook::HEAD_END,
                fn () => view('filament.admin.custom-styles')
            )
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
                RestaurantOverviewHeaderWidget::class,
                StatsOverviewWidget::class,
                OrdersChartWidget::class,
                OrderStatusChartWidget::class,
                RecentOrdersWidget::class,
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
