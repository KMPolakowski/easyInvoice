<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Elasticsearch\ClientBuilder;

use App\Observers\ItemObserver;
use App\User;
use App\Item;
use App\Invoice;

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

        $this->app->singleton(ClientBuilder::class, function ($app) {
            $client = ClientBuilder::create()->build();
            return $client;
        });
    }

    public function boot()
    {
        Item::observe(ItemObserver::class);
    }
}
