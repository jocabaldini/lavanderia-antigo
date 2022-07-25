<?php

namespace Lavanderia\Repositories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Lavanderia\Interfaces\ServiceInterface;
use Lavanderia\Models\Client;
use Lavanderia\Models\Item;
use Lavanderia\Models\Service;
use Lavanderia\Models\ServiceItem;
use \Exception;

class ServiceRepository implements ServiceInterface
{
	protected static $serviceStatus = [
		Service::STATUS_NOT_READY => 'Fazendo',
		Service::STATUS_READY => 'Prontos',
		Service::STATUS_NOT_DELIVERED => 'Não entregues',
		Service::STATUS_DELIVERED => 'Entregues',
		Service::STATUS_LATE => 'Atrasados' 
	];

	protected function filter(array $filters)
	{
		$services = Service::query();

		$status = $filters['status'];
		$deliveryAtStart = isset($filters['deliveryAtStart']) ? $filters['deliveryAtStart'] : '';
		$deliveryAtEnd = isset($filters['deliveryAtEnd']) ? $filters['deliveryAtEnd'] : '';
		
		if (! empty($status)) {
			$services->ofType($status);
		}

		if (
			! empty($deliveryAtStart) &&
			preg_match('/^[0-9]{4}\-[0-9]{2}\-[0-9]{2}$/', $deliveryAtStart)
		) {
			$dateArr = explode('-', $deliveryAtStart);
			$services->ofDeliveryStart(
				Carbon::create($dateArr[0], $dateArr[1], $dateArr[2], 0, 0, 0, config('app.timezone'))
			);
		}

		if (
			! empty($deliveryAtEnd) &&
			preg_match('/^[0-9]{4}\-[0-9]{2}\-[0-9]{2}$/', $deliveryAtEnd)
		) {
			$dateArr = explode('-', $deliveryAtEnd);
			$services->ofDeliveryEnd(
				Carbon::create($dateArr[0], $dateArr[1], $dateArr[2], 0, 0, 0, config('app.timezone'))
			);
		}

		return $services;
	}

	/**
	 * Função responsável por retornar uma coleção de registros.
	 * @param  Request $request Filtros da listagem.
	 * @return array            Array com o status e retorno da requisição.
	 */
	public function getAll(Request $request, $paginate = true, $perPage = 10)
	{
		try {
			$services = $this->filter($request->only(['status', 'deliveryAtStart', 'deliveryAtEnd']));

			$services = $services->with(['items','client']);

			$records = $services->get();

			if ($records instanceof Collection) {
				return [
					'status' => true,
					'records' => $records
				];
			}

			throw new Exception("Tipo de coleção não esperado");
			
		} catch (Exception $e) {
			return [
				'status' => false,
				'exception' => $e->getLine() . ' - ' . $e->getMessage()
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
			$service = Service::with('items.item.values')->findOrFail($id);
		
			if ($service instanceof Service)	{
				return [
					'status' => true,
					'record' => $service
				];
			}

			throw new Exception("Tipo de modelo não esperado");

		} catch (Exception $e) {
			return [
				'status' => false,
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
			$result = DB::transaction(function () use ($request) {
				$inputModel = $request->only(['delivery_at']);
				
				$newService = new Service($inputModel);
				$newService->client()->associate($request->get('client_id'));

				if ($newService->save()) {
					$serviceItems = new Collection;
					$inputRelationship = $request->get('items');
					
					foreach ($inputRelationship as $key => $itemInput) {
						$serviceItem = new ServiceItem($itemInput);
						$serviceItem->item()->associate($itemInput['item_id']);
						$serviceItems->push($serviceItem);
					}

					if ($newService->items()->saveMany($serviceItems) instanceof Collection) {
						return [
							'status' => true
						];
					}
				}

				throw new Exception("Erro ao criar item", 1);
			});

			return $result;

		} catch (Exception $e) {
			return [
				'status' => false,
				'exc' => $e->getLine() . ' - ' . $e->getMessage()
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
			$result = DB::transaction(function () use ($request, $id) {
				$service = Service::findOrFail($id);
				
				$service->delivery_at = $request->get('delivery_at');
				$service->client()->associate($request->get('client_id'));
				if ($service->save()) {

					foreach ($service->items as $item) {
						if (! $item->delete()) {
							throw new Exception("Erro ao remover item do serviço");							
						}
					}

					$serviceItems = new Collection;
					$inputRelationship = $request->get('items');
					
					foreach ($inputRelationship as $key => $itemInput) {
						$serviceItem = new ServiceItem($itemInput);
						$serviceItem->item()->associate($itemInput['item_id']);
						$serviceItems->push($serviceItem);
					}

					if ($service->items()->saveMany($serviceItems) instanceof Collection) {
						return [
							'status' => true
						];
					}
				}

				throw new Exception("Erro ao atualizar o serviço");
			});

			return $result;
		} catch (Exception $e) {
			return [
				'status' => false,
				'exception' => $e->getMessage(),
				'line' => $e->getLine()
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
			$result = DB::transaction(function () use ($id) {
				$service = Service::findOrFail($id);

				if ($service->delete()) {
					foreach ($service->items() as $serviceItem) {
						if (! $serviceItem->delete()) {
							throw new Exception("Erro ao remover item do serviço");
						}
					}

					return [
						'status' => true
					];
				}
			
				throw new Exception("Erro ao remover serviço");
			});

			return $result;
		} catch (Exception $e) {
			return [
				'status' => false
			];
		}
	}

	/**
	 * Função responsável por atualizar dados do serviço.
	 * @param  int    $id 	   Id do registro a ser atualizado.
	 * @param  array  $newInfo Novos dados do serviço.
	 * @return array      	   Array com o status da requisição.
	 */
	public function updateService($id, $newInfo)
	{
		try {
			$result = DB::transaction(function () use ($id, $newInfo) {
				$service = Service::findOrFail($id);
				
				if (! $service->update($newInfo)) {
					throw new Exception("Erro ao atualizar dados do serviço");
				}			
			});

			return ['status' => true];
		} catch (Exception $e) {
			return [
				'status' => false,
				'errorMsg' => $e->getLine() . ' - ' . $e->getMessage()
			];
		}
	}

	/**
	 * Função responsável por setar um serviço como pronto.
	 * @param  int    $id Id do registro a ser atualizado.
	 * @return array      Array com o status da requisição.
	 */
	public function ready($id)
	{
		$data = [
			'is_ready' => Service::IS_READY
		];

        return $this->updateService($id, $data);
	}

	/**
	 * Função responsável por setar um serviço como entregue.
	 * @param  int    $id Id do registro a ser atualizado.
	 * @return array      Array com o status da requisição.
	 */
	public function delivery($id)
	{
		$data = [
            'is_ready' => Service::IS_READY,
            'delivered_at' => Carbon::now()
        ];

        return $this->updateService($id, $data);
	}

	private function getTotalLateNotification()
	{
		$countLate = $this->filter(['status' => Service::STATUS_LATE])->count(); 
		
		$class = 'danger';
		$text = Lang::get('dashboard.notifications.one_late');
		
		if ($countLate === 0) {
			$class = 'success'; 
			$text = Lang::get('dashboard.notifications.none_late');
		} elseif ($countLate > 1) {
			$text = Lang::get('dashboard.notifications.multiple_late', [
				'count' => $countLate
			]);
		}

		return [
			'class' => $class,
			'text' => $text
		]; 
	}

	private function getWeekNotification()
	{
		$nextSunday = Carbon::now()->endOfWeek();

		$totalWeight = 0;
		$weekServices = $this->filter([
			'status' => Service::STATUS_NOT_READY,
			'deliveryAtEnd' => $nextSunday
		])->get()
		->map(function ($item, $key) use (&$totalWeight) {
			$totalWeight += (float) $item->total_weight;
		});
		$totalServices = count($weekServices);

		$class = 'info';
		$text = Lang::get('dashboard.notifications.week_info_one');
		
		if ($totalServices === 0 ) {
			$class = 'success';
			$text = Lang::get('dashboard.notifications.week_info_none');
		} else if ($totalServices > 1) {
			$text = Lang::get('dashboard.notifications.week_info_multiple', [
				'total' => $totalServices,
				'total_weight' => $totalWeight
			]);
		}

		return [
			'class' => $class,
			'text' => $text
 		];		
	}

	public function getNotifications()
	{
		try {
			
			$records = [];

			array_push($records, $this->getTotalLateNotification());

			array_push($records, $this->getWeekNotification());			

			return [
				'status' => 'true',
				'records' => $records
			];
		}  catch (Exception $e) {
			return [
				'status' => false,
				'errorMsg' => $e->getLine() . ' - ' . $e->getMessage()
			];
		} 	
	}

	public function getServiceStatus()
	{
		return static::$serviceStatus;
	}
}