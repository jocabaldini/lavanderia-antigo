<?php

namespace Lavanderia\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer(
            'service.index', 'Lavanderia\Http\ViewComposers\ServiceListComposer'
        );

        View::composer(
            [
                'service.partials._modal-service',
                'client.partials._modal-payment'
            ], 'Lavanderia\Http\ViewComposers\ServiceFormComposer'
        );

        View::composer(
            'service.partials._service-row', 'Lavanderia\Http\ViewComposers\ServiceItemFormComposer'
        );
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        
    }
}
