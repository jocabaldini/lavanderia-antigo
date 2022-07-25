<?php

namespace Lavanderia\Http\Controllers;

use Illuminate\Http\Request;
use Lavanderia\Interfaces\ItemInterface;
use Lavanderia\Traits\ResourceControllerTrait;

class ItemController extends Controller
{
    use ResourceControllerTrait;

    // Nome do módulo
    protected $moduleName;
	// Repositório
	protected $repository;
	// Telas
    protected $indexView;
   	protected $showView;
   	protected $createView;
   	protected $editView;
    // Botão para cadastrar
    protected $displayButton;
    protected $buttonText;
    protected $buttonRoute;

    public function __construct(ItemInterface $itemRepository)
    {
        $this->moduleName = 'Itens';
    	$this->repository = $itemRepository;
    	$this->indexView = 'item.index';
    	$this->showView = 'item.show';
    	$this->displayButton = true;
        $this->buttonText = 'Novo item';
        $this->buttonRoute = '#';
    }
}
