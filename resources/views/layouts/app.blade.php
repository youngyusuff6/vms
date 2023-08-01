<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ url('DASHBOARD_ASSETS/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ url('DASHBOARD_ASSETS/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ url('DASHBOARD_ASSETS/dist/css/adminlte.min.css') }}">
</head>

<body class="hold-transition @yield('page-type')">
    @yield('content')
    
    <script src="{{ url('DASHBOARD_ASSETS/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ url('DASHBOARD_ASSETS/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ url('DASHBOARD_ASSETS/dist/js/demo.js') }}"></script>

</body>

</html>
