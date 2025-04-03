<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Artisan;

class ClearCacheWidget extends Widget
{
    protected static ?int $sort = 1;
    protected static string $view = 'filament.widgets.clear-cache-widget';

    public function clearConfigCache()
    {
        // Clear config cache using Artisan
        Artisan::call('config:clear');
        
        // Show a success notification after clearing config cache
        Notification::make()
            ->title('Config Cache Cleared')
            ->success()
            ->send();
    }

    public function clearViewsCache()
    {
        // Clear views cache using Artisan
        Artisan::call('view:clear');
        
        // Show a success notification after clearing views cache
        Notification::make()
            ->title('Views Cache Cleared')
            ->success()
            ->send();
    }
    
}
