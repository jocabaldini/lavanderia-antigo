{!! Form::open(['class' => 'form-vertical form-client']) !!}
	{!! Form::hidden('id', isset($id) ? $id : 0) !!}
	<div>
		<!-- Nav tabs -->
		<ul class="nav nav-tabs client-form-tabs" role="tablist">
			<li role="presentation" class="active">
				<a href="#client-data" aria-controls="client-data" role="tab" data-toggle="tab">
					<i class="fa fa-user"></i> Dados
				</a>
			</li>
			<li role="presentation">
				<a href="#client-address" aria-controls="client-address" role="tab" data-toggle="tab">
					<i class="fa fa-home"></i> Endereço
				</a>
			</li>
			<li role="presentation">
				<a href="#client-contact" aria-controls="client-contact" role="tab" data-toggle="tab">
					<i class="fa fa-phone"></i> Contato
				</a>
			</li>
			<li role="presentation" class="client-history disabled">
				<a href="#client-history" aria-controls="client-history" role="tab" data-toggle="tab">
					<i class="fa fa-history"></i> Histórico
				</a>
			</li>
		</ul>

		<!-- Tab panes -->
		<div class="tab-content">
			<div role="tabpanel" class="tab-pane active" id="client-data">
				@include('client.partials._form-data')
			</div>
			<div role="tabpanel" class="tab-pane" id="client-address">
				@include('client.partials._form-address')
			</div>
			<div role="tabpanel" class="tab-pane" id="client-contact">
				@include('client.partials._form-contact')
			</div>
			<div role="tabpanel" class="tab-pane" id="client-history">
				@include('client.partials._form-history')
			</div>
		</div>
	</div>
	<div class="alert-box">
		<p class="alert"></p>
	</div>
	<div class="form-footer">
		{!! Form::submit('Salvar', ['class' => 'btn btn-primary']) !!}
		{!! Form::submit('Limpar', ['class' => 'btn btn-default btn-clear']) !!}
	</div>
{!! Form::close() !!}
