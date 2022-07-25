<?php

namespace Lavanderia\Interfaces;

use Illuminate\Http\Request;

interface RepositoryResourceInterface
{
	/**
	 * Função responsável por retornar uma coleção de registros.
	 * @param  Request $request Filtros da listagem.
	 * @return array            Array com o status e retorno da requisição.
	 */
	public function getAll(Request $request, $paginate = true, $perPage = 10);

	/**
	 * Função responsável por retornar um modelo de um registro.
	 * @param  int $id Id do registro.
	 * @return array   Array com o status e retorno da requisição.
	 */
	public function getOne($id);

	/**
	 * Função responsável por criar um novo registro.
	 * @param  Request $request Dados do novo registro.
	 * @return array            Array com o status da requisição.
	 */
	public function createModel(Request $request);

	/**
	 * Função responsável por atualizar um registro.
	 * @param  Request $request Novos dados do registro.
	 * @param  int     $id      Id do registro a ser atualizado.
	 * @return array            Array com o status da requisição.
	 */
	public function updateModel(Request $request, $id);

	/**
	 * Função responsável por remover um registro.
	 * @param  int    $id Id do registro a ser removido.
	 * @return array      Array com o status da requisição.
	 */
	public function deleteModel($id);
}