<?php

namespace App\Providers;
use App\Models\Outlet;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\ServiceProvider;

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
        View::composer('*', function ($view) {
            $global_member = null;
            if (Auth::check() && Auth::user()->member) {
                $global_member = Auth::user()->member;
            }
            $view->with('global_member', $global_member);
        });
        View::composer('*', function ($view) {
            if (Auth::check()) {
                $outlet = Outlet::find(Auth::user()->outlet_id);
                $view->with('global_outlet', $outlet);
            }
        });
        
    }
}
