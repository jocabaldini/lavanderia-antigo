<div class="row">
	<div class="col-md-9">
        <div class="form-group">
            {!! Form::label('address', 'Endereço') !!}
            {!! Form::text('address', null, ['class' => 'form-control']) !!}
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            {!! Form::label('number', 'Número') !!}
            {!! Form::number('number', null, ['class' => 'form-control']) !!}
        </div>
    </div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="form-group">
		    {!! Form::label('address2', 'Complemento') !!}
		    {!! Form::text('address2', null, ['class' => 'form-control']) !!}
		</div>
    </div>
    <div class="col-md-6">
		<div class="form-group">
		    {!! Form::label('neighborhood', 'Bairro') !!}
		    {!! Form::text('neighborhood', null, ['class' => 'form-control']) !!}
		</div>
    </div>
</div>
<div class="form-group">
    {!! Form::label('reference', 'Referência') !!}
    {!! Form::text('reference', null, ['class' => 'form-control']) !!}
</div>