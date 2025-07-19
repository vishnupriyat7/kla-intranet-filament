<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
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
            ->sidebarCollapsibleOnDesktop()
            ->sidebarWidth('18rem') // Optional: Set default sidebar width
            ->collapsedSidebarWidth('9rem') // Optional: Set collapsed width
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->colors([
                // 'primary' => Color::Amber,
                'primary' => '#3C5DF0',
                'danger' => Color::Rose,
                'gray' => Color::Gray,
                'info' => Color::Blue,
                // 'primary' => Color::Indigo,
                'success' => Color::Emerald,
                'warning' => Color::Orange,
            ])
            ->brandName('KLA INTRANET')
            ->favicon(asset('images/favicon.png'))
            ->font('Poppins')
            ->renderHook('panels::head.start', fn() => new \Illuminate\Support\HtmlString('
    <style>
        /* Sidebar background and text */
        .filament-sidebar,
        .filament-sidebar-header,
        .filament-sidebar nav {
            background: linear-gradient(180deg, #1e3a8a 0%, #2749b3 100%) !important;
            color: white !important;
        }

        .filament-sidebar a,
        .filament-sidebar nav a,
        .filament-sidebar span {
            color: #e0e7ff !important;
            font-weight: 500;
            transition: all 0.2s ease-in-out;
        }

        .filament-sidebar nav a {
            padding: 0.75rem 1rem !important;
            border-radius: 0.5rem;
            margin: 0.25rem 0.5rem;
        }

        /* Hover/active states */
        .filament-sidebar nav a:hover,
        .filament-sidebar nav a[aria-current="page"] {
            background-color: rgba(255, 255, 255, 0.15) !important;
            color: #ffffff !important;
        }

        /* Icons styling */
        .filament-sidebar nav a svg {
            color: #c7d2fe !important;
            transition: color 0.2s;
        }

        .filament-sidebar nav a:hover svg,
        .filament-sidebar nav a[aria-current="page"] svg {
            color: #ffffff !important;
        }

        /* Group titles / separators */
        .filament-sidebar nav h2 {
            padding: 0.75rem 1rem;
            font-size: 0.75rem;
            text-transform: uppercase;
            color: #a5b4fc !important;
            margin-top: 1rem;
        }

        /* Scrollbar removal */
        .filament-sidebar nav::-webkit-scrollbar {
            width: 0px;
            background: transparent;
        }

        /* Collapsed tooltip */
        .filament-sidebar-collapsed .filament-sidebar nav a span {
            display: none !important;
        }

        .filament-sidebar-collapsed .filament-sidebar nav a:hover::after {
            content: attr(title);
            position: absolute;
            left: 100%;
            margin-left: 8px;
            white-space: nowrap;
            background: #374151;
            color: #fff;
            padding: 5px 10px;
            font-size: 0.75rem;
            border-radius: 0.25rem;
            z-index: 9999;
        }
    </style>
'))

            ->maxContentWidth('full') // Set content width to full

            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])

            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                // Widgets\AccountWidget::class,
                // Widgets\FilamentInfoWidget::class,
                \App\Filament\Resources\OrderCircularResource\Widgets\OrderStats::class, // Added OrderStats
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
