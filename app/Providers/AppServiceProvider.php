<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\AppTenant;
use App\Observers\TenantObserver;

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
        // Force Laravel to use Tailwind for the ->links() output
        Paginator::useTailwind();

        AppTenant::observe(TenantObserver::class);

        View::composer('errors::*', function ($view) {
            $view->with('user', Auth::user());
        });

        // This will NOT trigger the log entry
        // AppTenant::withoutEvents(function () {
        //     AppTenant::where('plan', 'free')->update(['is_active' => false]);
        // });
    }
}
