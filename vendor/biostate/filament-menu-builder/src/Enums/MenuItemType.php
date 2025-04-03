<?php

namespace Biostate\FilamentMenuBuilder\Enums;

enum MenuItemType: string
{
    case Link = 'link';
    case Route = 'route';
    case Model = 'model';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Link => 'Link',
            self::Route => 'Route',
            self::Model => 'Model',
        };
    }

    public static function fromValue(string $value): self
    {
        return match ($value) {
            'route' => self::Route,
            'model' => self::Model,
            default => self::Link,
        };
    }
}
