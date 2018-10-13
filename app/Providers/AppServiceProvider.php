<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\User;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(User::class, function ($app) {
            $user = User::find(7);

            return $user;
        });
    }
}
