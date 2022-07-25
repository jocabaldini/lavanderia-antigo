<div class="form-group col-md-4 item-group">
	{!! Form::label('items[][item_id]', 'Item') !!}
	<a href="#" class="service-remove text-danger">
		<i class="fa fa-times" aria-hidden="true"></i>
	</a>
	{!! Form::select('items[][item_id]', $items, null, ['class' => 'form-control trigger-item']) !!}
</div>
<div class="form-group col-md-2">
	{!! Form::label('items[][type]', 'Serviço') !!}
	{!! Form::select('items[][type]', [], null, ['class' => 'form-control trigger-service', 'disabled']) !!}
</div>
<div class="form-group col-md-2">
	{!! Form::label('items[][price]', 'Preço') !!}
	{!! Form::number('items[][price]', null, ['class' => 'form-control trigger-price', 'disabled']) !!}
</div>
<div class="form-group col-md-2">
	{!! Form::label('items[][quantity]', 'Quantidade') !!}
	{!! Form::number(
		'items[][quantity]',
		null,
		[
			'class' => 'form-control trigger-quantity',
			'disabled',
			'step' => '0.001'
		]
	) !!}
</div>
<div class="form-group col-md-2">
	{!! Form::label('items[][total]', 'Total') !!}
	{!! Form::text('items[][total]', 'R$ 0,00', ['class' => 'form-control item-total', 'readonly']) !!}
</div>