<?php

namespace App\Providers;

use App\Models\User;
use App\Observers\UserObserver;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

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
    public function boot(UrlGenerator $url): void{
        Schema::defaultStringLength(191);

        /* Observer on User class */
        User::observe(UserObserver::class);

        if (env('APP_ENV') !== 'local') { //so you can work on it locally
            $url->forceScheme('https');
        }
    }
}
