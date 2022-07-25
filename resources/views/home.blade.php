@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-8">
            <h3 class="title">{{ \Lang::get('dashboard.delivery_today') }}</h3>
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
        </div>
        <div class="col-md-4">
            <h3 class="title">{{ \Lang::get('dashboard.notification') }}</h3>
            <div class="notification-loading"><i class="fa fa-spinner fa-spin"></i></div>
            <div class="notification-container">
            </div>
        </div>
    </div>
@endsection

@push('post-scripts')
    <script src="{{ asset('js/home.js') }}"></script>
@endpush
