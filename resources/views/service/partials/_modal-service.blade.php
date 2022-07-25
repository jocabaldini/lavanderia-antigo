<div class="modal fade" id="modal-service" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body">
				{!! Form::open(['class' => 'form-vertical form-service', 'novalidate']) !!}
					{!! Form::hidden('id', isset($id) ? $id : 0) !!}
					<h4 class="service-title">{{ isset($id) ? 'Editando serviço #'.$id : 'Novo serviço'}}</h4>
					<div class="row">
						<div class="form-group col-md-3">
							{!! Form::label('client_id', 'Cliente') !!}
							{!! Form::select('client_id', $clients, null, ['class' => 'form-control']) !!}
						</div>

						<div class="form-group col-md-2 hidden">
							{!! Form::label('created_at', 'Recebido em') !!}
							{!! Form::date('created_at', date('Y-m-d'), ['class' => 'form-control readonly']) !!}
						</div>
						
						<div class="form-group col-md-2">
							{!! Form::label('delivery_at', 'Data da entrega') !!}
							{!! Form::date('delivery_at', date('Y-m-d'), ['class' => 'form-control trigger-date']) !!}
						</div>

						<div class="form-group col-md-2">
							{!! Form::label('today', 'Hoje') !!}
							{!! Form::date('today', date('Y-m-d'), ['class' => 'form-control', 'readonly']) !!}
						</div>

						<div class="form-group col-md-2">
							{!! Form::label('delivery_text', 'Entrega em') !!}
							{!! Form::text('delivery_text', 'Hoje', ['class' => 'form-control days-left', 'readonly']) !!}
						</div>
					</div>
					<div class="panel panel-default">
						<div class="panel-body service-container">
							<div class="service-items">
								<div class="row">
									@include('service.partials._service-row')						
								</div>
							</div>
							<a href="#" class="add-service-item">
								<i class="fa fa-plus" aria-hidden="true"></i> <strong>Adicionar item</strong>
							</a>
						</div>
						<div class="panel-footer">
							<button class="btn btn-primary">Salvar</button>
							<button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
							<span class="service-total pull-right">R$ 0,00</span>					
						</div>
					</div>
				{!! Form::close() !!}
            </div>
        </div><!-- /.modal-content -->
		<div class="modal-message-overflow"><span>Informação</span></div>
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->