<?php

namespace Biostate\FilamentMenuBuilder\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Biostate\FilamentMenuBuilder\FilamentMenuBuilder
 */
class FilamentMenuBuilder extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Biostate\FilamentMenuBuilder\FilamentMenuBuilder::class;
    }
}
