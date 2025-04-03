<?php

namespace Biostate\FilamentMenuBuilder\Enums;

enum MenuItemTarget: string
{
    case Self = '_self';
    case Blank = '_blank';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Self => __('filament-menu-builder::menu_items.target._self'),
            self::Blank => __('filament-menu-builder::menu_items.target._blank'),
        };
    }
}
