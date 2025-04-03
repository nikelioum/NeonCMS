<?php

namespace Biostate\FilamentMenuBuilder\Commands;

use Illuminate\Console\Command;

class FilamentMenuBuilderCommand extends Command
{
    public $signature = 'filament-menu-builder';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
