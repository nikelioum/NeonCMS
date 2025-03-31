<?php

namespace App\Filament\Settings\Forms;

use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\TextInput;

class Analytics
{
    /**
     * @return Tab
     */
    public static function getTab(): Tab
    {
        return Tab::make('analytics')
                    ->label(__('Analytics'))
                    ->icon('heroicon-o-computer-desktop')
                    ->schema(self::getFields())
                    ->columns()
                    ->statePath('analytics')
                    ->visible(true);
    }

    public static function getFields(): array
    {
        return [
            TextInput::make('facebook_pixel_id'),
            TextInput::make('google_analytics_tracking_id')
        ];
    }

    public static function getSortOrder(): int
    {
       return 1;
    }
}
