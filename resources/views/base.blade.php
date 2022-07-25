@extends('layouts.app')

@section('content')
	<div class="module-header">
		<h2>{{ $moduleName }}</h2>
		{{-- @if($displayButton)
			<a href="{{ $buttonRoute }}" class="btn btn-info">{{ $buttonText }}</a>
		@endif --}}
	</div>
	    
    @yield('content-module')
@endsection

