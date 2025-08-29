<?php

namespace App\Providers;
use App\Models\Companies;
use Illuminate\Support\Facades\View;
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
    public function boot()
    {
        View::composer('layouts._sidebar', function ($view) {
            $view->with('company', Companies::first());
        });
    }
}
