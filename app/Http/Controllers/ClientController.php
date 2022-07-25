<?php

namespace Lavanderia\Http\Controllers;

use Illuminate\Http\Request;
use Lavanderia\Interfaces\ClientInterface;
use Lavanderia\Traits\ResourceControllerTrait;

class ClientController extends Controller
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

    public function __construct(ClientInterface $clientRepository)
    {
        $this->moduleName = 'Clientes';
    	$this->repository = $clientRepository;
    	$this->indexView = 'client.index';
    	$this->displayButton = false;/*
        $this->buttonText = 'Novo cliente';
        $this->buttonRoute = '#';*/
    }

    public function payment(Request $request, $id = null)
    {
        return $this->repository->payment($request->all(), $id);
    }

    public function editPayment($id)
    {
        return $this->repository->loadPayment($id);
    }
}
