@extends('base')

@section('content-module')
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
            <div class="panel panel-primary">
            	<div class="panel-heading">Novo item</div>
            	<div class="panel-body">
            		@include('item.partials._form')
            	</div>
            	<div class="panel-footer">
                    <a href="#" class="btn btn-primary btn-save">Salvar</a>
            		<a href="{{ route('items.index') }}" class="btn btn-default">Voltar</a>
            	</div>
            </div>
        </div>
    </div>
@endsection

@push('post-scripts')
    <script src="{{ asset('js/jquery.mask.min.js') }}"></script>
    <script src="{{ asset('js/item/form-functions.js') }}"></script>
    <script src="{{ asset('js/item/create.js') }}"></script>
@endpush