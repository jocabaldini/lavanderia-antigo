{!! Form::open(['class' => 'form-vertical form-item']) !!}
	<h3 class="form-title">Novo item</h3>
	<div class="row">
		{!! Form::hidden('id', isset($id) ? $id : 0) !!}
			<div class="form-group col-md-8">
				{!! Form::label('name', 'Nome') !!}
				{!! Form::text('name', null, ['class' => 'form-control']) !!}
			</div>
	</div>
	<h4>Preços</h4>
	<div class="row">
			<div class="form-group col-md-4">
				{!! Form::label('values[laundry_price]', 'Lavar') !!}
				{!! Form::number('values[laundry_price]', null,
					[
						'class' => 'form-control input-price',
						'step' => '0.01',
						'novalidate'
					]
				) !!}
			</div>
			<div class="form-group col-md-4">
				{!! Form::label('values[ironing_price]', 'Passar') !!}
				{!! Form::number('values[ironing_price]', null,
					[
						'class' => 'form-control input-price',
						'step' => '0.01',
						'novalidate'
					]
				) !!}
			</div>
			<div class="form-group col-md-4">
				{!! Form::label('values[both_price]', 'Ambos') !!}
				{!! Form::number('values[both_price]', null,
					[
						'class' => 'form-control input-price',
						'step' => '0.01',
						'novalidate'
					]
				) !!}
			</div>
	</div>
	<div class="form-alert-box">
	</div>
	<div class="buttons-container">
		<button type="button" class="btn btn-default btn-clear-form">Cancelar</button>
		<button class="btn btn-primary btn-save">Salvar</button>
	</div>
{!! Form::close() !!}
