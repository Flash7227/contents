<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Харилцаа Холбооны Зохицуулах Хороо</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    {{-- <script src="{{ asset('js/login.js') }}" defer></script> --}}
    @yield('scripts')

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    @yield('logincss')
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="icon" type="image/png" href="/imgs/khoroo2.png" />
    <link href="/include/main.css" rel="stylesheet">
</head>
<body>
    <div id="app" >
        @include('layouts.inc.navbar')
        <main class="main-content">
            @yield('content')
        </main>
    </div>
    @include('layouts.inc.footer')
</body>
</html>
