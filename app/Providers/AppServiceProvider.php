<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Gate;
use App\Models\User;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define('download-backup', function (User $user){
          return in_array($user->email, explode(',', env('BACKUP_MANAGERS')));
        });

        Gate::define('delete-backup', function (User $user){
            return in_array($user->email, explode(',', env('BACKUP_MANAGERS')));
          });
    }
}
