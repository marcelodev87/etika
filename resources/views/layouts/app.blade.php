<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{-- CSRF Token --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    {{-- Font Awesome --}}
    <link href="{{ asset('css/fontawesome.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/sweetalert.min.css') }}" rel="stylesheet"/>
    @yield('style')
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet"/>

</head>
<body class="{{ (in_array(Request::route()->getName(), ['password.email', 'password.reset', 'password.request', 'login', 'register'])) ? 'body-bg-color' : 'sidebar-mini'}}">

<div class="wrapper">
    @if (\Auth::check())
        @include('layouts.header')
        @include('layouts.aside')
    @endif

    {{-- verificação se a página é em branco ou faz parte do dashboard --}}
    @if (in_array(Request::route()->getName(), ['password.email', 'password.reset', 'password.request', 'login', 'register']))
        @yield('content')
    @else
        <div class="content-wrapper">
            @yield('header')
            <section class="content container-fluid">
                @yield('content')
            </section>
        </div>
    @endif
    @yield('modal')
</div>

<!-- Scripts -->
<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/script.js') }}"></script>
<script src="{{ asset('js/jquery.mask.min.js') }}"></script>
<script src="{{ asset('js/sweetalert.min.js') }}"></script>
<script src="{{ asset('js/application.js') }}"></script>

<script type="text/javascript">
    $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
    $.fn.modal.prototype.constructor.Constructor.DEFAULTS.backdrop = 'static';
    $.fn.modal.prototype.constructor.Constructor.DEFAULTS.keyboard =  false;
    $(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>

@yield('script')
</body>
</html>
