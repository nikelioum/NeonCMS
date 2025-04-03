<?php

namespace Biostate\FilamentMenuBuilder\Views;

use Illuminate\Support\Facades\Cache;
use Illuminate\View\Component;

class Menu extends Component
{
    public $menu;

    public $menuItems;

    public function __construct(
        string $slug,
        public string $view = 'filament-menu-builder::components.plain.menu',
    ) {
        $menu = \Biostate\FilamentMenuBuilder\Models\Menu::query()
            ->where('slug', $slug)
            ->first();

        if (! $menu) {
            return;
        }

        $menuDtoClass = config('filament-menu-builder.dto.menu');
        $this->menu = $menuDtoClass::fromModel($menu);
        $menuItemDtoClass = config('filament-menu-builder.dto.menu_item');

        $lastUpdated = $menu->getAttribute('updated_at')?->format('Y-m-d-h:i:s');
        $slug = $menu->getAttribute('slug');

        if (! config('filament-menu-builder.cache.enabled')) {
            $menuItems = $this->fetchMenuItems($menu);
            $this->menuItems = $menuItemDtoClass::fromCollection($menuItems);

            return;
        }

        $cacheKey = config('filament-menu-builder.cache.key');
        $cacheTtl = config('filament-menu-builder.cache.ttl');

        // TODO: change this to flexible cache
        $menuItems = Cache::remember("{$cacheKey}.{$slug}.{$lastUpdated}", $cacheTtl, function () use ($menu) {
            return $this->fetchMenuItems($menu);
        });
        $this->menuItems = $menuItemDtoClass::fromCollection($menuItems);
    }

    public function fetchMenuItems($menu)
    {
        return $menu
            ->items()
            ->defaultOrder()
            ->with('menuable')
            ->get()
            ->toTree();
    }

    public function render()
    {
        return view($this->view);
    }
}
