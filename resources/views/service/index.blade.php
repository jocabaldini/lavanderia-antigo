@extends('layouts.app')

@section('content')
    
    @include('partials._header')
	
    <div class="filter-container">
        {!! Form::open(['url' => '#', 'class' => 'form-horizontal form-filter', 'method' => 'GET']) !!}
            <div class="row">
                <div class="col-sm-3 col-md-2">
                    {!! Form::label('status', 'Status') !!}
                    {!! Form::select('status', $serviceStatus, 3, ['class' => 'form-control']) !!}
                </div>

                <div class="col-sm-9 col-md-10">
                    <div class="checkbox-dates">
                        {!! Form::label('filter_date', 'Filtrar por data') !!}
                        {!! Form::checkbox('filter_date', '', false) !!}
                    </div>
                    <div class="form-dates">
                        <div>
                            {!! Form::label('start_delivery_at', 'Desde') !!}
                            {!! Form::date('start_delivery_at', date('Y-m-d'), ['class' => 'form-control']) !!}
                        </div>
                        <div>
                            {!! Form::label('end_delivery_at', 'Até') !!}
                            {!! Form::date('end_delivery_at', date('Y-m-d'), ['class' => 'form-control']) !!}
                        </div>
                    </div>
                </div>
            </div>
        {!! Form::close() !!}
    </div>
    <div class="table-responsive">
        @include('service.partials._service-trigger')
        <table id="services-table" class="table table-bordered table-condensed">
            <thead>
                <th>Cliente</th>
                <th>Entregar</th>
                <th>Entregue</th>
                <th>Valor</th>
                <th class="col-actions">Ações</th>
            </thead>
            <tfoot>
                <th colspan="5"></th>
            </tfoot>
        </table>
    </div>


@endsection

@push('post-scripts')
    <script src="{{ asset('js/service/index.js') }}"></script>
@endpush