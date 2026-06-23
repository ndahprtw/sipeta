<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>SIPETA (Sistem Informasi Pemetaan Tanah)</title>

    <!-- Favicons -->
    <link href="{{ asset('assets/img/logo.png') }}" rel="icon">
    <link href="{{ asset('assets/img/logo.png') }}" rel="apple-touch-icon">

    <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}">

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>
</head>
<body>

    @yield('content')

    @yield('scripts')

</body>
</html>