# An Elegant Menu Builder for Filament

[![Latest Version on Packagist](https://img.shields.io/packagist/v/biostate/filament-menu-builder.svg?style=flat-square)](https://packagist.org/packages/biostate/filament-menu-builder)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/biostate/filament-menu-builder/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/biostate/filament-menu-builder/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/biostate/filament-menu-builder/fix-php-code-styling.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/biostate/filament-menu-builder/actions?query=workflow%3A"Fix+PHP+code+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/biostate/filament-menu-builder.svg?style=flat-square)](https://packagist.org/packages/biostate/filament-menu-builder)

> **Note:** I developed this package as a hobby project, but wanted to share it with whoever may need it. I will keep updating this package. If you have any suggestions, feel free to create an issue.

This package offers a powerful menu builder for the Filament admin panel, enabling efficient menu creation and management.

- Integrate models and routes into menu items for dynamic and flexible navigation.
- Render menus with Blade components for consistency and adaptability.

Built for simplicity and performance, this package ensures a seamless solution for managing menus in the Filament admin panel.

![Dark Theme](https://github.com/Biostate/filament-menu-builder/blob/main/art/configuration-dark.jpg?raw=true)
![Light Theme](https://github.com/Biostate/filament-menu-builder/blob/main/art/configuration-light.jpg?raw=true)

Table of Contents:
- [Installation](#installation)
- [Caching](#caching)
- [Menuable Trait](#menuable-trait)
- [Routes](#routes)
- [Blade Components](#blade-components)
- [TODO](#todo)

## Installation

You can install the package via composer:

```bash
composer require biostate/filament-menu-builder
```

Add the plugin to your `AdminPanelServiceProvider.php`:

```php
public function panel(Panel $panel): Panel
{
    return $panel
        // Your other configurations
        ->plugins([
            \Biostate\FilamentMenuBuilder\FilamentMenuBuilderPlugin::make(), // Add this line
        ]);
}
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="filament-menu-builder-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="filament-menu-builder-config"
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="filament-menu-builder-views"
```

## Caching

Menu items are cached in view component by default. If you want to disable caching, you can set the `cache` configuration to `false`.

## Menuable Trait

You can create relationships between menu items and your models. To enable this feature, you need to add the `Menuable` trait to your model and implement the `getMenuLinkAttribute` method.
If you want to use the model name as the menu item name, you can use the `getMenuNameAttribute` method.

```php
use Biostate\FilamentMenuBuilder\Traits\Menuable;

class Product extends Model
{
    use Menuable;
    
    public function getMenuLinkAttribute(): string
    {
        return route('products.show', $this);
    }
    
    public function getMenuNameAttribute(): string
    {
        return $this->name;
    }
}
```

After this you need to add your model in to the config file. You can add multiple models. eg:

```php
return [
    'models' => [
        'Product' => \App\Models\Product::class,
    ],
];
```

If you add these configurations, you can see the menu items in the menu item forms as a select input.

## Routes

You can use your routes in the menu items. But if you want to exclude some routes, you can use the `exclude_route_names` configuration.
Package excludes the debugbar routes, filament routes, and livewire routes in default.

```php
'exclude_route_names' => [
    '/^debugbar\./', // Exclude debugbar routes
    '/^filament\./',   // Exclude filament routes
    '/^livewire\./',   // Exclude livewire routes
],
```

## Blade Components

This package provides some blade components to render the menu items. You can use these components in your blade files. You can get this code in the menus table. For example:

```html
<x-filament-menu-builder::menu slug="main-menu" />
```

This blade component will render the menu items with the `main-menu` slug. You can also publish the views and customize the blade components.

Also you can give a custom view to the component. This package supports Bootstrap 5 by default. For example:

```html
<x-filament-menu-builder::menu slug="main-menu" view="filament-menu-builder::components.bootstrap5.menu"/>
```

## TODO

- [ ] add parameters like mega menu, dropdown, etc.
- [ ] add tests
- [ ] add tailwind blade component
- [ ] add "Do you want to discard the changes?" if you have unsaved changes
- [ ] add more actions like: move up, move down, move one level up, move one level down, etc.

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Süleyman Özgür Özarpacı](https://github.com/Biostate)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
