<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class ClearCacheWidget extends Widget
{
    protected static ?int $sort = 2;
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


    public function deleteActivityLogs(){
         
        DB::table('activity_log')->truncate();

        // Show a success notification after clearing views cache
        Notification::make()
            ->title('Activity Logs Cleared')
            ->success()
            ->send();
    }
    
}
