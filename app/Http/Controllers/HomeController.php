<?php

namespace Lavanderia\Http\Controllers;

use Illuminate\Http\Request;
use Lavanderia\Interfaces\ServiceInterface;

class HomeController extends Controller
{
    protected $service;
    // Nome do módulo
    protected $moduleName;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ServiceInterface $service)
    {
        $this->moduleName = 'Dashboard';
        $this->service = $service;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home', ['moduleName' => $this->moduleName]);
    }

    public function notifications()
    {
        return response()->json($this->service->getNotifications());
    }
}
