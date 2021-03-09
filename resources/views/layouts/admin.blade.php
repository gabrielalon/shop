<!doctype html>
<html lang="{{locale()->current()}}" dir="{{locale()->dir()}}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">

    <!-- Styles -->
    <link href="{{ mix('css/admin/app.css') }}" rel="stylesheet">
    @yield('css-script')
</head>
<body>
    <div id="app">
        @include ('layouts.nav.admin')

        <main class="py-4">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        @include('layouts.flash-message')
                    </div>
                </div>
            </div>

            @yield('content')
        </main>
    </div>

    <div class="clearfix"></div>

    <!-- Scripts -->
    <script src="{{ mix('js/admin/app.js') }}"></script>
    @yield('js-script')

    @include ('layouts.footer.admin')
</body>
</html>
