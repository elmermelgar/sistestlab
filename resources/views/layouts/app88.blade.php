<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'TestLab') }}</title>

    <!-- Styles -->

    <!-- Bootstrap -->
    <link href="{{public_path().'gentallela/vendors/bootstrap/dist/css/bootstrap.min.css'}}" rel="stylesheet">
    <!-- Font Awesome -->

@yield('styles')
<!-- Custom Theme Style -->
    <link href="{{public_path().'css/custom.css'}}" rel="stylesheet">

    @yield('imports')

</head>

<body class="nav-md">

<div class="container body">
    <div class="main_container">

        <!-- page content -->
        <div class="right_col" role="main">
            <div class="content">
                @yield('content')
            </div>
        </div>
        <!-- /page content -->
    </div>
</div>

<!-- Scripts -->

</body>
</html>
