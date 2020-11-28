<?php

namespace App\Providers;

use Inertia\Inertia;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Session as FacadesSession;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Inertia::share('flash', function () {
            return ['success' => FacadesSession::get('success')];
        });
        Inertia::share('errors', function () {
            return FacadesSession::get('errors') ? FacadesSession::get('errors')->getBag('default')->getMessages() : (object)[];
        });
    }
}
 