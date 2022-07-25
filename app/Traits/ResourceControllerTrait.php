<?php

namespace Lavanderia\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

trait ResourceControllerTrait
{
    /*
    |--------------------------------------------------------------------------
    | View functions
    |--------------------------------------------------------------------------
    */
    /**
     * Redireciona para a tela de listagem de registros.
     * @return View
     */
    public function index()
    {
        if (
            view()->exists($this->indexView) &&
            is_string($this->moduleName) &&
            is_bool($this->displayButton)
        ) {
            $variables = [
                'moduleName' => $this->moduleName,
                'displayButton' => $this->displayButton,
            ];

            if ($this->displayButton) {
                if (
                    is_string($this->buttonText) &&
                    (Route::has($this->buttonRoute) || '#' === $this->buttonRoute)
                ) {
                    $variables['buttonText'] = $this->buttonText;
                    $variables['buttonRoute'] = ('#' === $this->buttonRoute) ? '#' : route($this->buttonRoute);
                } else {
                    return view('errors.error');
                }
            }

            return view($this->indexView, $variables);
        }
        
        return view('errors.error');
    }

    /**
     * Redireciona para a tela de exibição de um registro.
     * @param  int $id Id do registro a ser exibido.
     * @return View
     */
    public function show($id)
    {
        if (
            view()->exists($this->showView) &&
            is_string($this->moduleName) &&
            is_bool($this->displayButton)
        ) {
            $variables = [
                'moduleName' => $this->moduleName,
                'displayButton' => $this->displayButton,
            ];

            if ($this->displayButton) {
                if (
                    is_string($this->buttonText) &&
                    (Route::has($this->buttonRoute) || '#' === $this->buttonRoute)
                ) {
                    $variables['buttonText'] = $this->buttonText;
                    $variables['buttonRoute'] = ('#' === $this->buttonRoute) ? '#' : route($this->buttonRoute);
                } else {
                    return view('errors.error');
                }
            }

            return view($this->showView, $variables);
        }
        
        return view('errors.error');
    }

    /**
     * Redireciona para a tela de criação de um registro.
     * @return View
     */
    public function create()
    {
        if (
            view()->exists($this->createView) &&
            is_string($this->moduleName) &&
            is_bool($this->displayButton)
        ) {
            $variables = [
                'moduleName' => $this->moduleName,
                'displayButton' => $this->displayButton,
            ];

            if ($this->displayButton) {
                if (
                    is_string($this->buttonText) &&
                    (Route::has($this->buttonRoute) || '#' === $this->buttonRoute)
                ) {
                    $variables['buttonText'] = $this->buttonText;
                    $variables['buttonRoute'] = ('#' === $this->buttonRoute) ? '#' : route($this->buttonRoute);
                } else {
                    return view('errors.error');
                }
            }

            return view($this->createView, $variables);
        }
        
        return view('errors.error');
    }

    /**
     * Redireciona para a tela de edição de um registro.
     * @param  int $id Id do registro a ser exibido.
     * @return View
     */
    public function edit($id)
    {
        if (
            view()->exists($this->editView) &&
            is_string($this->moduleName) &&
            is_bool($this->displayButton) &&
            is_int(intval($id))
        ) {
            $variables = [
                'moduleName' => $this->moduleName,
                'displayButton' => $this->displayButton,
                'id' => $id
            ];

            if ($this->displayButton) {
                if (
                    is_string($this->buttonText) &&
                    (Route::has($this->buttonRoute) || '#' === $this->buttonRoute)
                ) {
                    $variables['buttonText'] = $this->buttonText;
                    $variables['buttonRoute'] = ('#' === $this->buttonRoute) ? '#' : route($this->buttonRoute);
                } else {
                    return view('errors.error');
                }
            }

            return view($this->editView, $variables);
        }
        
        return view('errors.error');
    }

    /*
    |--------------------------------------------------------------------------
    | Data functions
    |--------------------------------------------------------------------------
    */
    /**
     * Retorna uma coleção de registros.
     * @param  Request $request Filtros da listagem.
     * @return JsonResponse     Json contendo uma coleção de registros.
     */
    public function all(Request $request)
    {
        return response()->json(
            $this->repository->getAll($request)
        );
    }

    /**
     * Retorna um registro.
     * @param  int $id Id do registro.
     * @return JsonResponse   Json contendo um modelo do registro.
     */
    public function one($id)
    {
        return response()->json(
            $this->repository->getOne($id)
        );
    }

    /**
     * Salva um novo registro.
     * @param  Request $request Dados do novo registro.
     * @return JsonResponse     Json contendo o status da requisição.
     */
    public function store(Request $request)
    {
        return response()->json(
            $this->repository->createModel($request)
        );
    }

    /**
     * Atualiza um registro.
     * @param  Request $request Novos dados do registro.
     * @param  int $id Id do registro.
     * @return JsonResponse     Json contendo o status da requisição.
     */
    public function update(Request $request, $id)
    {
        return response()->json(
            $this->repository->updateModel($request, $id)
        );
    }

    /**
     * Remove um registro.
     * @param  int $id Id do registro.
     * @return JsonResponse     Json contendo o status da requisição.
     */
    public function destroy($id)
    {
        return response()->json(
            $this->repository->deleteModel($id)
        );
    }
}
