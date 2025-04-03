<?php

namespace Biostate\FilamentMenuBuilder;

use Biostate\FilamentMenuBuilder\Filament\Resources\MenuItemResource;
use Biostate\FilamentMenuBuilder\Filament\Resources\MenuResource;
use Filament\Contracts\Plugin;
use Filament\Panel;

class FilamentMenuBuilderPlugin implements Plugin
{
    public function getId(): string
    {
        return 'filament-menu-builder';
    }

    public function register(Panel $panel): void
    {
        $panel->resources([
            MenuResource::class,
            MenuItemResource::class,
        ]);
    }

    public function boot(Panel $panel): void
    {
        //
    }

    public static function make(): static
    {
        return app(static::class);
    }

    public static function get(): static
    {
        /** @var static $plugin */
        $plugin = filament(app(static::class)->getId());

        return $plugin;
    }
}
