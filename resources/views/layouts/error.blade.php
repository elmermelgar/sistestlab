<!DOCTYPE html>
<html lang="en">
<head>
    <title>{{ config('app.name', 'TestLab') }}</title>

    <!-- Bootstrap -->
    <link href="{{url('gentallela/vendors/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{url('css/font-awesome.min.css')}}" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="{{url('css/custom.css')}}" rel="stylesheet">
</head>

<body class="nav-md">
<div class="container body">
    <div class="main_container">
        <!-- page content -->
        <div class="col-md-12">
            <div class="col-middle">
                <div class="text-center text-center">
                    <h1 class="error-number">@yield('error-number')</h1>
                    <h2 style="color: white">@yield('error-title')</h2>
                    <p style="color: white">@yield('error-description')</p>
                </div>
            </div>
        </div>
        <!-- /page content -->
    </div>
</div>

<!-- jQuery -->
<script src="{{url('gentallela/vendors/jquery/dist/jquery.min.js')}}"></script>
<!-- Bootstrap -->
<script src="{{url('gentallela/vendors/bootstrap/dist/js/bootstrap.min.js')}}"></script>
<!-- NProgress -->
<script src="{{url('gentallela/vendors/nprogress/nprogress.js')}}"></script>

<!-- Custom Theme Scripts -->
<script src="{{url('js/custom.js')}}"></script>
</body>
</html>