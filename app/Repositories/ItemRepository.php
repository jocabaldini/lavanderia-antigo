<?php

namespace Lavanderia\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Lavanderia\Interfaces\ItemInterface;
use Lavanderia\Models\Item;
use Lavanderia\Models\ItemValue;
use \Exception;

class ItemRepository implements ItemInterface
{
	/**
	 * Função responsável por retornar uma coleção de registros.
	 * @param  Request $request Filtros da listagem.
	 * @return array            Array com o status e retorno da requisição.
	 */
	public function getAll(Request $request, $paginate = true, $perPage = 10)
	{
		try {
			$records = Item::with(['values'])->get();

			return [
				'status' => true,
				'records' => $records
			];


			if($paginate) {
				$records = $records->paginate($perPage);
			} else {
				$records = $records->get();
			}

			if (
				$records instanceof Collection ||
				$records instanceof LengthAwarePaginator
			) {
				return [
					'status' => true,
					'records' => $records
				];
			}

			throw new Exception("Tipo de coleção não esperado");
			
		} catch (Exception $e) {
			return [
				'status' => false
			];
		}
	}

	/**
	 * Função responsável por retornar um modelo de um registro.
	 * @param  int $id Id do registro.
	 * @return array   Array com o status e retorno da requisição.
	 */
	public function getOne($id)
	{
		try {
			$item = Item::with('values')->findOrFail($id);
		
			if ($item instanceof Item)	{
				return [
					'status' => true,
					'record' => $item
				];
			}

			throw new Exception("Tipo de modelo não esperado");

		} catch (Exception $e) {
			return [
				'status' => false
			];
		}		
	}

	/**
	 * Função responsável por criar um novo registro.
	 * @param  Request $request Dados do novo registro.
	 * @return array            Array com o status da requisição.
	 */
	public function createModel(Request $request)
	{
		try {
			$result = DB::transaction(function() use ($request) {
				$inputModel = $request->only(['name']);
				
				$newItem = Item::create($inputModel);

				if ($newItem instanceof Item) {
					$inputRelationship = $request->only(['values']);
					
					$values = new ItemValue($inputRelationship['values']);

					if ($newItem->values()->save($values) instanceof ItemValue) {
						return [
							'status' => true
						];
					}
				}

				throw new Exception("Erro ao criar item", 1);
			});

			return $result;

		} catch (Exception $e) {
			return $e;
			return [
				'status' => false,
				'exc' => $e
			];
		}		
	}

	/**
	 * Função responsável por atualizar um registro.
	 * @param  Request $request Novos dados do registro.
	 * @param  int     $id      Id do registro a ser atualizado.
	 * @return array            Array com o status da requisição.
	 */
	public function updateModel(Request $request, $id)
	{
		try {
			$result = DB::transaction(function() use ($request, $id) {
				$item = Item::findOrFail($id);
				$inputModel = $request->only(['name']);

				if ($item->update($inputModel)) {
					$inputRelationship = $request->only(['values']);
					$newValues = $inputRelationship['values'];
					$oldValues = $item->values()->first(); 
					if (
						$oldValues->laundryPrice != $newValues['laundry_price'] ||
						$oldValues->ironingPrice != $newValues['ironing_price'] ||
						$oldValues->bothPrice != $newValues['both_price']
					) {
						if ($oldValues->delete()) {
							$values = new ItemValue($newValues);

							if ($item->values()->save($values) instanceof ItemValue) {
								return [
									'status' => true
								];
							}
						}
					} else {
						return [
							'status' => true
						];
					}
				}

				throw new Exception("Erro ao atualizar item");
			});

			return $result;
		} catch (Exception $e) {
			return [
				'status' => false
			];
		}
	}

	/**
	 * Função responsável por remover um registro.
	 * @param  int    $id Id do registro a ser removido.
	 * @return array      Array com o status da requisição.
	 */
	public function deleteModel($id)
	{
		try {
			$result = DB::transaction(function() use ($id) {
				$item = Item::findOrFail($id);

				if ($item->delete() && $item->values()->first()->delete()) {
					return [
						'status' => true
					];
				}
			
				throw new Exception("Erro ao remover item");
			});

			return $result;
		} catch (Exception $e) {
			return [
				'status' => false
			];
		}
	}
}