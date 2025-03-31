<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Gate;
use App\Models\User;
use Spatie\Health\Facades\Health;
use Spatie\Health\Checks\Checks\OptimizedAppCheck;
use Spatie\Health\Checks\Checks\DebugModeCheck;
use Spatie\Health\Checks\Checks\EnvironmentCheck;
use Spatie\Health\Checks\Checks\DatabaseCheck;
use Spatie\CpuLoadHealthCheck\CpuLoadCheck;
use Spatie\Health\Checks\Checks\DatabaseTableSizeCheck;
use Spatie\Health\Checks\Checks\UsedDiskSpaceCheck;
use Spatie\SecurityAdvisoriesHealthCheck\SecurityAdvisoriesCheck;

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


          Health::checks([
            OptimizedAppCheck::new(),
            DebugModeCheck::new(),
            EnvironmentCheck::new()->expectEnvironment('local'),
            DatabaseCheck::new(),
            CpuLoadCheck::new()
            ->failWhenLoadIsHigherInTheLast5Minutes(2.0)
            ->failWhenLoadIsHigherInTheLast15Minutes(1.5),
            DatabaseTableSizeCheck::new()
            ->table('app_settings', maxSizeInMb: 1_000)
            ->table('cache', maxSizeInMb: 1_000)
            ->table('cache_locks', maxSizeInMb: 1_000)
            ->table('categories', maxSizeInMb: 1_000)
            ->table('category_post', maxSizeInMb: 1_000)
            ->table('failed_jobs', maxSizeInMb: 1_000)
            ->table('health_check_result_history_items', maxSizeInMb: 1_000)
            ->table('jobs', maxSizeInMb: 1_000)
            ->table('job_batches', maxSizeInMb: 1_000)
            ->table('menus', maxSizeInMb: 1_000)
            ->table('menu_items', maxSizeInMb: 1_000)
            ->table('migrations', maxSizeInMb: 1_000)
            ->table('model_has_permissions', maxSizeInMb: 1_000)
            ->table('model_has_roles', maxSizeInMb: 1_000)
            ->table('pages', maxSizeInMb: 1_000)
            ->table('password_reset_tokens', maxSizeInMb: 1_000)
            ->table('permissions', maxSizeInMb: 1_000)
            ->table('posts', maxSizeInMb: 1_000)
            ->table('post_tag', maxSizeInMb: 1_000)
            ->table('roles', maxSizeInMb: 1_000)
            ->table('role_has_permissions', maxSizeInMb: 1_000)
            ->table('sessions', maxSizeInMb: 1_000)
            ->table('tags', maxSizeInMb: 1_000)
            ->table('users', maxSizeInMb: 1_000),
            UsedDiskSpaceCheck::new()->warnWhenUsedSpaceIsAbovePercentage(60)->failWhenUsedSpaceIsAbovePercentage(80),
            SecurityAdvisoriesCheck::new(),
        ]);
    }
}
