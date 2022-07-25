<div class="modal fade" id="modal-payment" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-body">
            	<h3 class="form-title">Novo pagamento</h3>
			    {!! Form::open(['class' => 'form-vertical form-payment']) !!}
				    {!! Form::hidden('payment_id', 0) !!}
			        <div class="form-group">
						{!! Form::label('client_id', 'Cliente') !!}
						{!! Form::select('client_id', $clients, null, ['class' => 'form-control']) !!}
					</div>
				    <div class="form-group">
				        {!! Form::label('value', 'Valor') !!}
				        {!! Form::number('value', null, ['class' => 'form-control', 'step' => '0.01']) !!}
				    </div>
			    	<button href="#" class="btn btn-primary btn-save-payment">Salvar</button>  
			    {!! Form::close() !!}
            </div>
        </div><!-- /.modal-content -->
		<div class="modal-message-overflow"><span>Informação</span></div>
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->