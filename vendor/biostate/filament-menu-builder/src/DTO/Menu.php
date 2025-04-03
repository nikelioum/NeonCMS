<?php

namespace Biostate\FilamentMenuBuilder\DTO;

use Illuminate\Support\Collection;

class Menu
{
    public function __construct(
        public string $name,
        public string $slug,
    ) {
        //
    }

    public static function fromModel($model): self
    {
        return new Menu(
            name: $model->name,
            slug: $model->slug,
        );
    }

    public static function fromCollection(Collection $collection): Collection
    {
        return $collection->map(fn ($item) => static::fromModel($item));
    }
}
