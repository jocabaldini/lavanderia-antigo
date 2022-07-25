<div class="box-payment-loading hidden">
    <i class="fa fa-spinner fa-spin"></i>
</div>
<div class="box-payment hidden">
    <h3 class="form-title">Novo pagamento</h3>
    {!! Form::open(['class' => 'form-inline form-payment']) !!}
    {!! Form::hidden('payment_id', 0) !!}
    <div class="form-group">
        {!! Form::label('value', 'Valor') !!}
        {!! Form::number('value', null, ['class' => 'form-control', 'step' => '0.01']) !!}
    </div>
    <button href="#" class="btn btn-primary btn-save-payment">Salvar</button>  
    {!! Form::close() !!}
    <div class="alert-box-payment">
    </div>
</div>