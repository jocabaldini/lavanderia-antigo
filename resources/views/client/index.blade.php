@extends('base')

@section('content-module')
<div class="client-container row">
    <div class="col-md-7 client-table-box">
        <div class="table-responsive">
            <table id="clients-table" class="table table-bordered table-condensed">
                <thead>
                    <th>Código</th>
                    <th>Nome</th>
                    <th class="col-actions">Ações</th>
                </thead>
            </table>
        </div>{{-- .table-responsive --}}
    </div>
    <div class="col-md-5 client-form-box">
        <button class="hidden display-form-trigger btn btn-success">
            <i class="fa fa-plus"></i>
            <i class="fa fa-user"></i>
        </button>
        <fieldset>
            <legend>
                <span>Novo cliente</span>
            </legend>
            @include('client.partials._form')
        </fieldset>
    </div>{{-- .same-height-col --}}
</div>{{-- .client-container --}}

        {{-- 
        <div class="col-md-6">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active">
                    <a href="#form" aria-controls="form" role="tab" data-toggle="tab">Formulário</a>
                </li>
                <li role="presentation" class="disabled">
                    <!-- <a href="#history" aria-controls="history" role="tab" data-toggle="tab">Histórico</a> -->
                    <a href="#history" aria-controls="history" role="tab">Histórico</a>
                </li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="form">
                    <h3 class="form-title">Novo cliente</h3>
                    <div class="row">
                        {!! Form::open(['class' => 'form-vertical form-client']) !!}
                        {!! Form::hidden('id', isset($id) ? $id : 0) !!}
                        <div class="col-md-3">
                            <div class="form-group">
                                {!! Form::label('code', 'Código') !!}
                                {!! Form::text('code', null, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="col-md-10">
                            <div class="form-group">
                                {!! Form::label('name', 'Nome') !!}
                                {!! Form::text('name', null, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                    <div class="alert-box">
                    </div>
                    <a href="#" class="btn btn-primary btn-save">Salvar</a>
                </div>
                <div role="tabpanel" class="tab-pane" id="history">
                    <a href="#" class="show-payment-form"><i class="fa fa-plus"></i> Pagamento</a>
                    @include('client.partials._form-payment')
                    
                    <h3 class="form-title">Histórico</h3>
                    <div class="table-responsive pre-scrollable">
                        
                    </div>
                    <div class="client-balance">
                        <h4>Saldo: <strong><span>R$ 0,00</span></strong></h4>
                    </div>
                </div>
            </div>
        </div> --}}
@endsection

@push('post-scripts')
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.16/datatables.min.js"></script>
    <script src="{{ asset('js/client/index.js') }}"></script>
@endpush