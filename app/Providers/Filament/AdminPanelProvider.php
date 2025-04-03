<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
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
use App\Filament\Widgets\BlogStats;
use pxlrbt\FilamentSpotlight\SpotlightPlugin;
use ShuvroRoy\FilamentSpatieLaravelBackup\FilamentSpatieLaravelBackupPlugin;
use ShuvroRoy\FilamentSpatieLaravelHealth\FilamentSpatieLaravelHealthPlugin;
use Tapp\FilamentMailLog\FilamentMailLogPlugin;
use Z3d0X\FilamentFabricator\FilamentFabricatorPlugin;
use App\Filament\Widgets\NeonCms;
use Rmsramos\Activitylog\ActivitylogPlugin;


class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->colors([
                'primary' => Color::Amber,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                NeonCms::class,
                BlogStats::class,
                \App\Filament\Widgets\ClearCacheWidget::class,
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
            ->plugins([
                FilamentShieldPlugin::make(), //User roles
                \Biostate\FilamentMenuBuilder\FilamentMenuBuilderPlugin::make(), // Menu Builder
                \CWSPS154\AppSettings\AppSettingsPlugin::make()->canAccess(function () {
                    return true;
                })
                ->canAccessAppSectionTab(function () {
                    return true;
                })
                ->appAdditionalField([]),
                SpotlightPlugin::make(),
                FilamentSpatieLaravelBackupPlugin::make(),
                FilamentSpatieLaravelHealthPlugin::make(),
                FilamentMailLogPlugin::make(),
                FilamentFabricatorPlugin::make(),
                ActivitylogPlugin::make()->navigationGroup('Activity Log'),
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
