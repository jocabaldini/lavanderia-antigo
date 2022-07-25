<div class="form-group">
    {!! Form::label('email', 'E-mail') !!}
    {!! Form::email('email', null, ['class' => 'form-control']) !!}
</div>
<div class="row">
	<div class="col-md-6">
        <div class="form-group">
            {!! Form::label('cel', 'Celular') !!}
            {!! Form::text('cel', null, ['class' => 'form-control cel']) !!}
        </div>
    </div>
	<div class="col-md-6">
        <div class="form-group">
            {!! Form::label('phone', 'Telefone') !!}
            {!! Form::text('phone', null, ['class' => 'form-control phone']) !!}
        </div>
    </div>
</div>