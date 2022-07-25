@extends('base')

@section('css')
    {{-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs/dt-1.10.16/datatables.min.css"/>--}}
     <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.16/datatables.min.css"/>
@endsection

@section('content-module')
	<div class="row">
		<div class="col-md-8 col-lg-6">
            <table id="item-table" class="table table-bordered table-condensed">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Lavar</th>
                        <th>Passar</th>
                        <th>Ambos</th>
                        <th class="col-actions">Ações</th>
                    </tr>
                </thead>
            </table>
        </div>
        <div class="col-md-4 col-lg-6">
            <div class="well form-container">
                @include('item.partials._form')
            </div>
        </div>
	</div>
@endsection

@push('post-scripts')
    {{-- <script type="text/javascript" src="https://cdn.datatables.net/v/bs/dt-1.10.16/datatables.min.js"></script> --}}
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.16/datatables.min.js"></script>
    <script src="{{ asset('js/jquery.mask.min.js') }}"></script>
    <script src="{{ asset('js/item/index.js') }}"></script>
@endpush