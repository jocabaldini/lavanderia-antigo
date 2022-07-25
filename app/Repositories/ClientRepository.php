<?php

namespace Lavanderia\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Lavanderia\Interfaces\ClientInterface;
use Lavanderia\Models\Client;
use Lavanderia\Models\Payment;
use \Exception;

class ClientRepository implements ClientInterface
{
	/**
	 * Função responsável por retornar uma coleção de registros.
	 * @param  Request $request Filtros da listagem.
	 * @return array            Array com o status e retorno da requisição.
	 */
	public function getAll(Request $request, $paginate = false, $perPage = 10)
	{
		try {
			if($paginate) {
				$records = Client::paginate($perPage);
			} else {
				$records = Client::all();
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
			$client = Client::findOrFail($id);
			$services = $client->services()->with('items')->get();
			$payments = $client->payments;
			$history = $services->merge($payments)->sortBy('created_at')->values()->all();
			
			if ($client instanceof Client)	{
				return [
					'status' => true,
					'record' => [
						'client' => $client,
						'history' => $history
					]
				];
			}

			throw new Exception("Tipo de modelo não esperado");

		} catch (Exception $e) {
			return [
				'status' => false,
				'error' => $e->getMessage()
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
				$input = $request->only([
					'code', 'name', 'address', 'number', 'address2', 'neighborhood', 'reference', 'email', 'cel', 'phone'
				]);

				$input['cel'] = preg_replace('/\D/', '', $input['cel']);
				$input['phone'] = preg_replace('/\D/', '', $input['phone']);
				$newClient = Client::create($input);

				if ($newClient instanceof Client) {
					return [
						'status' => true,
						'id' => $newClient->id
					];
				} else {
					throw new Exception("Erro ao criar cliente");
				}
			});

			return $result;

		} catch (Exception $e) {
			return [
				'status' => false
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
				$input = $request->only([
					'code', 'name', 'address', 'number', 'address2', 'neighborhood', 'reference', 'email', 'cel', 'phone'
				]);
				$input['cel'] = preg_replace('/\D/', '', $input['cel']);
				$input['phone'] = preg_replace('/\D/', '', $input['phone']);
				
				$client = Client::findOrFail($id);

				if ($client->update($input)) {
					return [
						'status' => true
					];
				} else {
					throw new Exception("Erro ao atualizar cliente");
				}
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
				$client = Client::findOrFail($id);

				if ($client->delete()) {
					return [
						'status' => true
					];
				} else {
					throw new Exception("Erro ao remover cliente");
				}
			});

			return $result;
		} catch (Exception $e) {
			return [
				'status' => false
			];
		}
	}

	public function payment($payment, $id)
	{
		try {
			if (is_null($id)) {
				$client = Client::findOrFail($payment['client_id']);

				$newPayment = new Payment;
				$newPayment->value = $payment['value'];


				if ($client->payments()->save($newPayment) instanceof Payment) {
					return ['status' => true];
				}
			} else {
				$p = Payment::findOrFail($id);

				if ($p->update(['value' => $payment['value']])) {
					return ['status' => true];
				}
			}

			return ['status' => false];
		} catch (Exception $e) {
			return [
				'status' => false,
				'message' => $e->getMessage(),
				'line' => $e->getLine(),
				'payment' => $payment
			];
		}
	}

	public function loadPayment($id)
	{
		try {
			$payment = Payment::findOrFail($id);

			return [
				'status' => true,
				'record' => $payment
			];

		} catch (Exception $e) {
			return [
				'status' => false,
				'message' => $e->getMessage()
			];
		}
	}
}