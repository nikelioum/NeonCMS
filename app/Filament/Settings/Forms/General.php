<?php

namespace App\Filament\Settings\Forms;

use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\TextInput;

class General
{
    /**
     * @return Tab
     */
    public static function getTab(): Tab
    {
        return Tab::make('social-media')
                    ->label(__('Social Media'))
                    ->icon('heroicon-o-computer-desktop')
                    ->schema(self::getFields())
                    ->columns()
                    ->statePath('social-media')
                    ->visible(true);
    }

    public static function getFields(): array
    {
        return [
            TextInput::make('facebook')->url(),
            TextInput::make('instagram')->url(),
            TextInput::make('tiktok')->url(),
            TextInput::make('twitter')->url()
        ];
    }

    public static function getSortOrder(): int
    {
       return 1;
    }
}
