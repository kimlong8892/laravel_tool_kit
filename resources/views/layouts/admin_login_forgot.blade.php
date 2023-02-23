<!doctype html>
<html lang="en">
<head>
    @hasSection('title')
        <title>{{ env('APP_NAME') }} - @yield('title')</title>
    @else
        <title>{{ env('APP_NAME') }}</title>
    @endif
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
</head>
<body>
    <section class="ftco-section">
        <div class="container">
            @yield('content')
        </div>
    </section>
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('lib/fontawesome/css/all.css') }}"/>
    <link rel="stylesheet" href="{{ asset('theme/admin_login/css/style.css') }}">
    <script src="{{ asset('theme/admin_login/js/jquery.min.js') }}"></script>
    <script src="{{ asset('theme/admin_login/js/popper.js') }}"></script>
    <script src="{{ asset('theme/admin_login/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('theme/admin_login/js/main.js') }}"></script>
    @yield('js')
</body>
</html>

