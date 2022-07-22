<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

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
    <link rel="icon" type="image/png" href="/imgs/meta.png" />
    <link href="/include/main.css" rel="stylesheet">
</head>
<body>
    <div id="app">
        @include('layouts.inc.navbar')
        <main class="py-4">
            @yield('content')
        </main>
        <!-- <el-footer class="container">
            <div class="row">
            <div class="col-md-6">
                <h5>Холбоос</h5>
                <div class="row">

                    <div class="col-md-6">
                        <ul class="list links">
                            <li><a href="http://crc.gov.mn">Байгууллагын веб хуудас</a></li>
                            <li><a href="https://zipcode.mn/">Шуудангийн нэгдсэн кодын систем</a></li>
                            <li><a href="http://www.black-list.mn//">Зөрчилтэй домайны жагсаалт </a></li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <ul class="list links">
                            <li><a href="http://www.facebook.com/crcmongol">Facebook холбоос</a></li>
                            <li><a href="http://www.twitter.com/crcmn">Twitter холбоос</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <h5>Холбоо барих</h5>
                <div class="row">
                    <div class="col-md-6">
                        <div class="c-info" style="margin-top: 15px">
                            <i class="fa fa-map-marker"></i>
                            Метро бизнес төв А-блок 5 давхар Д.Сүхбаатарын гудамж-13 Сүхбаатар дүүрэг, Улаанбаатар 14201-0033
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="c-info">
                            <i class="fa fa-envelope-o"></i>
                            <a href="mailto:info@crc.gov.mn">info@crc.gov.mn</a>
                        </div>
                        <div class="c-info">
                            <i class="fa fa-phone"></i>
                            +976-11-304258
                            <br>
                            1800-1858
                        </div>
                        <div class="c-info">
                            <i class="fa fa-fax"></i>
                            +976-11-327720
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </el-footer> -->
    </div>
</body>
</html>
