<?php

namespace Lavanderia\Http\ViewComposers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Lavanderia\Repositories\ClientRepository;

class ServiceFormComposer
{
    /**
     * The client repository implementation.
     *
     * @var ClientRepository
     */
    protected $clients;

    /**
     * Create a new profile composer.
     *
     * @param  ClientRepository  $clients
     * @return void
     */
    public function __construct(ClientRepository $clients)
    {
        // Dependencies automatically resolved by service container...
        $this->clients = $clients;
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $clients = $this->clients->getAll(new Request, false);

        if ($clients['status']) {
            $clients = $clients['records']
                        ->sortBy('code')
                        ->map(function ($client, $key) {
                            $client->codeName = $client->code . ' - ' . $client->name;
                            return $client;
                        });

            $clients = [0 => 'Selecione'] + $clients->pluck('codeName', 'id')->toArray();

            $view->with('clients', $clients);
        } else {
            $view->with('clients', []);
        }
    }
}