<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('components/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('components/datatable/datatables.min.css') }}" rel="stylesheet">


    @yield('css')

    <!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
</head>
<body>
    <div class="loading_overlay"></div>
    @if(! Auth::guest())
        @include('service.partials._modal-service')
        @include('client.partials._modal-payment')
    @endif

    @yield('modal-content')
    <div id="app-lavanderia">
        @if (! Auth::guest())
            @include('partials._navbar')
        @endif
        
        <div class="container">
            @yield('content')
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    @if(! Auth::guest())
        <script src="{{ asset('js/utils.js') }}"></script>
        <script src="{{ asset('js/jquery.mask.min.js') }}"></script>
        <script src="{{ asset('js/service/script.js') }}"></script>
        <script src="{{ asset('js/client/payment.js') }}"></script>
        <script src="{{ asset('components/datatable/datatables.min.js') }}"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                $("#modal-service,#modal-payment").on("shown.bs.modal", function (e) {
                    let overflow = $(this).find(".modal-message-overflow")
                    let overflowMsg = overflow.find("span")

                    console.log(overflow.height())
                    console.log(overflowMsg.height())

                    overflowMsg.css("margin-top", (overflow.height() - overflowMsg.height()) / 2)                
                })
            })
        </script>
    @endif
    @stack('post-scripts')
</body>
</html>
