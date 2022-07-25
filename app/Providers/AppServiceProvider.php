<?php

namespace Lavanderia\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            'Lavanderia\Interfaces\ClientInterface',
            'Lavanderia\Repositories\ClientRepository'
        );

        $this->app->bind(
            'Lavanderia\Interfaces\ItemInterface',
            'Lavanderia\Repositories\ItemRepository'
        );

        $this->app->bind(
            'Lavanderia\Interfaces\ServiceInterface',
            'Lavanderia\Repositories\ServiceRepository'
        );
    }
}
