<?php

namespace Lavanderia\Http\ViewComposers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Lavanderia\Repositories\ItemRepository;

class ServiceItemFormComposer
{
    /**
     * The item repository implementation.
     *
     * @var ItemRepository
     */
    protected $items;

    /**
     * Create a new profile composer.
     *
     * @param  ItemRepository  $items
     * @return void
     */
    public function __construct(ItemRepository $items)
    {
        // Dependencies automatically resolved by service container...
        $this->items = $items;
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $items = $this->items->getAll(new Request, false);

        if ($items['status']) {
            $items = [0 => 'Selecione'] + $items['records']->pluck('name', 'id')->toArray();

            $view->with('items', $items);
        } else {
            $view->with('items', []);
        }
    }
}