<?php

namespace Lavanderia\Http\ViewComposers;

use Illuminate\View\View;
use Lavanderia\Repositories\ServiceRepository;

class ServiceListComposer
{
    /**
     * The service repository implementation.
     *
     * @var ServiceRepository
     */
    protected $services;

    /**
     * Create a new profile composer.
     *
     * @param  ServiceRepository  $services
     * @return void
     */
    public function __construct(ServiceRepository $services)
    {
        // Dependencies automatically resolved by service container...
        $this->services = $services;
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('serviceStatus', [0 => 'Todos'] + $this->services->getServiceStatus());
    }
}