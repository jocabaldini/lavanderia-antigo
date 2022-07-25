<?php

namespace Lavanderia\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Lavanderia\Interfaces\ServiceInterface;
use Lavanderia\Models\Service;
use Lavanderia\Traits\ResourceControllerTrait;

class ServiceController extends Controller
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

    public function __construct(ServiceInterface $serviceRepository)
    {
        $this->moduleName = 'Serviços';
    	$this->repository = $serviceRepository;
    	$this->indexView = 'service.index';
    	//$this->showView = 'service.show';
    	//$this->createView = 'service.form';
    	//$this->editView = 'service.form';
        $this->displayButton = false;
        //$this->buttonText = 'Novo serviço';
        //$this->buttonRoute = 'services.create';
    }

    public function serviceItem()
    {
        $result = [
            'status' => 0
        ];

        if (View::exists('service.partials._service-row')) {
            $result['status'] = 200;
            $result['responseJson'] = View::make('service.partials._service-row')->render();
        }

        return response()->json($result); 
    }

    public function ready($service)
    {
        return response()->json(
            $this->repository->ready($service)
        );
    }

    public function delivery($service)
    {
        return response()->json(
            $this->repository->delivery($service)
        );
    }
}
